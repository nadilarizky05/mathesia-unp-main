<?php

namespace App\Http\Controllers;

use App\Models\FinalTest;
use App\Models\FinalTestAnswer;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FinalTestController extends Controller
{
    public function start(Request $request, $materialId)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu.'
                ], 401);
            }

            // Validasi progress
            $progress = StudentProgress::where('user_id', $user->id)
                ->where('material_id', $materialId)
                ->first();

            if (!$progress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan selesaikan semua materi sebelum memulai tes akhir.'
                ], 400);
            }

            $totalSections = $progress->material?->sections()->count() ?? 0;
            $completedCount = count($progress->completed_section ?? []);

            if ($totalSections > 0 && $completedCount < $totalSections) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selesaikan semua bagian materi terlebih dahulu sebelum mengikuti tes akhir.'
                ], 400);
            }

            // Ambil soal
            $finalTest = FinalTest::where('material_id', $materialId)
                ->with('material')
                ->first();

            if (!$finalTest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tes akhir belum tersedia untuk materi ini. Silakan hubungi guru Anda.'
                ], 404);
            }

            if (empty($finalTest->questions) || !is_array($finalTest->questions)) {
                Log::error('Final test has no questions', [
                    'final_test_id' => $finalTest->id,
                    'material_id' => $materialId
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Soal tes akhir belum diinput. Silakan hubungi guru Anda.'
                ], 400);
            }

            $duration = $finalTest->duration_minutes ?? 60;

            // Cek attempt yang ada
            $attempt = FinalTestAnswer::where('user_id', $user->id)
                ->where('material_id', $materialId)
                ->first();

            // ✅ PERBAIKAN: Jika sudah submit, JANGAN RESET jawaban
            if ($attempt && $attempt->is_submitted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tes akhir ini sudah dikumpulkan sebelumnya.',
                    'finalTest' => $this->formatFinalTestData($finalTest),
                    'attempt' => $this->formatAttemptData($attempt),
                    'isReadOnly' => true,
                ]);
            }

            // ✅ PERBAIKAN: Jika belum submit dan expired, perpanjang waktu TANPA reset jawaban
            if ($attempt && $attempt->expires_at && now()->greaterThan($attempt->expires_at) && !$attempt->is_submitted) {
                // Perpanjang waktu, tapi PERTAHANKAN jawaban yang ada
                $attempt->update([
                    'expires_at' => now()->addMinutes($duration),
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Waktu tes diperpanjang. Jawaban Anda tetap tersimpan.',
                    'finalTest' => $this->formatFinalTestData($finalTest),
                    'attempt' => $this->formatAttemptData($attempt),
                ]);
            }

            // ✅ Jika belum ada attempt sama sekali, buat baru dengan jawaban kosong
            if (!$attempt) {
                $initialAnswers = collect($finalTest->questions)->map(function ($q, $index) {
                    return [
                        'question_index' => $index,
                        'answer_text' => null,
                        'answer_file' => null,
                        'score' => null,
                        'feedback' => null,
                    ];
                })->toArray();

                $attempt = FinalTestAnswer::create([
                    'user_id' => $user->id,
                    'material_id' => $materialId,
                    'started_at' => now(),
                    'expires_at' => now()->addMinutes($duration),
                    'is_submitted' => false,
                    'answers' => $initialAnswers,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tes akhir dimulai. Selamat mengerjakan!',
                'finalTest' => $this->formatFinalTestData($finalTest),
                'attempt' => $this->formatAttemptData($attempt),
            ]);

        } catch (\Exception $e) {
            Log::error('Error starting final test', [
                'material_id' => $materialId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memulai tes akhir. Silakan coba lagi atau hubungi guru Anda.'
            ], 500);
        }
    }

    public function saveAnswer(Request $request, $attemptId, $questionId)
    {
        try {
            $user = Auth::user();

            $attempt = FinalTestAnswer::where('id', $attemptId)
                ->where('user_id', $user->id)
                ->first();

            if (!$attempt) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi tes tidak ditemukan.'
                ], 404);
            }

            // ✅ PERBAIKAN: Jika sudah submit, TOLAK perubahan
            if ($attempt->is_submitted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tes sudah dikumpulkan. Tidak bisa mengubah jawaban.'
                ], 400);
            }

            // ✅ Cek apakah waktu sudah habis (tapi masih izinkan save sebelum submit)
            if ($attempt->expires_at && now()->greaterThan($attempt->expires_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu tes sudah habis. Silakan kumpulkan jawaban Anda.'
                ], 400);
            }

            $validated = $request->validate([
                'answer_text' => 'nullable|string',
                'answer_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20480',
            ]);

            $answerText = $validated['answer_text'] ?? null;
            $answerFile = null;

            // ✅ PERBAIKAN: Handle file upload dengan lebih hati-hati
            if ($request->hasFile('answer_file')) {
                $oldAnswer = $attempt->getAnswerForQuestion($questionId);
                
                // Hapus file lama HANYA jika tidak sedang di-submit
                if ($oldAnswer && !empty($oldAnswer['answer_file']) && !$attempt->is_submitted) {
                    Storage::disk('public')->delete($oldAnswer['answer_file']);
                }
                
                // Simpan file baru dengan nama unik
                $file = $request->file('answer_file');
                $extension = $file->getClientOriginalExtension();
                $filename = 'answer_' . $attemptId . '_q' . $questionId . '_' . time() . '.' . $extension;
                $answerFile = $file->storeAs('final_answers', $filename, 'public');
            }

            // Update answer
            $attempt->updateAnswer($questionId, $answerText, $answerFile);

            $updatedAnswer = $attempt->getAnswerForQuestion($questionId);

            return response()->json([
                'success' => true,
                'message' => $answerFile ? 'File jawaban berhasil disimpan!' : 'Jawaban berhasil disimpan!',
                'answer' => [
                    'id' => $attempt->id,
                    'question_id' => $questionId,
                    'answer_text' => $updatedAnswer['answer_text'] ?? null,
                    'answer_file' => $updatedAnswer['answer_file'] ?? null,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving answer', [
                'attempt_id' => $attemptId,
                'question_id' => $questionId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jawaban. Silakan coba lagi.'
            ], 500);
        }
    }

    public function submit($attemptId)
    {
        try {
            $user = Auth::user();

            $attempt = FinalTestAnswer::where('id', $attemptId)
                ->where('user_id', $user->id)
                ->first();

            if (!$attempt) {
                return back()->with('toast', [
                    'type' => 'error',
                    'message' => 'Sesi tes tidak ditemukan.'
                ]);
            }

            if ($attempt->is_submitted) {
                return back()->with('toast', [
                    'type' => 'error',
                    'message' => 'Tes sudah dikumpulkan sebelumnya.'
                ]);
            }

            // ✅ PERBAIKAN: Tandai sebagai submitted dan simpan waktu selesai
            $attempt->update([
                'finished_at' => now(),
                'is_submitted' => true,
            ]);

            // Update progress
            StudentProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'material_id' => $attempt->material_id,
                ],
                [
                    'is_completed' => true,
                    'progress_percent' => 100,
                    'completed_at' => now(),
                ]
            );

            return back()->with('toast', [
                'type' => 'success',
                'message' => 'Tes akhir berhasil dikumpulkan! Jawaban Anda telah tersimpan.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting final test', [
                'attempt_id' => $attemptId,
                'error' => $e->getMessage()
            ]);

            return back()->with('toast', [
                'type' => 'error',
                'message' => 'Gagal mengumpulkan tes. Silakan coba lagi.'
            ]);
        }
    }

    // Helper methods
    private function formatFinalTestData($finalTest)
    {
        return [
            'id' => $finalTest->material_id,
            'title' => $finalTest->material->title ?? 'Tes Akhir',
            'duration' => $finalTest->duration_minutes,
            'questions' => collect($finalTest->questions)->map(function ($q, $index) {
                return [
                    'id' => $index,
                    'question' => $q['question'] ?? '',
                    'max_score' => $q['max_score'] ?? 10,
                ];
            })->values()->toArray(),
        ];
    }

    private function formatAttemptData($attempt)
    {
        return [
            'id' => $attempt->id,
            'student_id' => $attempt->user_id,
            'material_id' => $attempt->material_id,
            'started_at' => $attempt->started_at?->toIso8601String(),
            'expires_at' => $attempt->expires_at?->toIso8601String(),
            'finished_at' => $attempt->finished_at?->toIso8601String(),
            'is_submitted' => (bool) $attempt->is_submitted,
            'answers' => collect($attempt->answers ?? [])->map(fn($a) => [
                'id' => $attempt->id,
                'question_id' => $a['question_index'],
                'answer_text' => $a['answer_text'] ?? null,
                'answer_file' => $a['answer_file'] ?? null,
            ])->toArray(),
        ];
    }
}