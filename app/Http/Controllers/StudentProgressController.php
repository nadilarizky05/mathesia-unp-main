<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class StudentProgressController extends Controller
{
    /**
     * Tampilkan semua progres user login di Home (Agregasi per SubTopic)
     */
    public function index()
    {
        $user = Auth::user();

        // ✅ PERBAIKAN: Ambil progress dan hitung per subtopic
        $rawProgress = StudentProgress::with(['subTopic.topic', 'gameCode', 'material'])
            ->where('user_id', $user->id)
            ->get();

        // Group by sub_topic_id untuk menghitung progress per subtopic
        $progressBySubtopic = [];

        foreach ($rawProgress as $item) {
            $subTopicId = $item->sub_topic_id;
            
            if (!isset($progressBySubtopic[$subTopicId])) {
                $progressBySubtopic[$subTopicId] = [
                    'sub_topic' => [
                        'id' => $item->subTopic->id,
                        'title' => $item->subTopic->title,
                    ],
                    'level' => $item->level,
                    'game_code' => $item->gameCode ? [
                        'id' => $item->gameCode->id,
                        'code' => $item->gameCode->code,
                    ] : null,
                    'total_sections' => 0,
                    'completed_sections' => 0,
                    'materials' => [],
                ];
            }

            // Hitung total sections untuk material ini
            $material = $item->material;
            if ($material) {
                $totalSections = 1 + $material->sections()->count() + 1; // Video + Sections + Tes
                $completedSections = count($item->completed_section ?? []);

                $progressBySubtopic[$subTopicId]['total_sections'] += $totalSections;
                $progressBySubtopic[$subTopicId]['completed_sections'] += $completedSections;
                $progressBySubtopic[$subTopicId]['materials'][] = [
                    'id' => $material->id,
                    'title' => $material->title,
                ];
            }
        }

        // ✅ Format output untuk frontend dengan progress_percent yang benar
        $progress = collect($progressBySubtopic)->map(function ($data) {
            $progressPercent = $data['total_sections'] > 0
                ? min(100, round(($data['completed_sections'] / $data['total_sections']) * 100))
                : 0;

            return [
                'id' => $data['sub_topic']['id'],
                'sub_topic' => $data['sub_topic'],
                'material' => $data['materials'][0] ?? null, // Ambil material pertama untuk link
                'game_code' => $data['game_code'],
                'level' => $data['level'],
                'progress_percent' => $progressPercent,
                'is_completed' => $progressPercent === 100,
                'completed_at' => null, // Bisa dihitung dari semua materials jika semua selesai
            ];
        })->values()->all();

        return Inertia::render('Home', [
            'studentProgress' => $progress,
        ]);
    }

    /**
     * Ambil progres berdasarkan subtopic
     */
    public function show($subtopicId)
    {
        $user = Auth::user();

        $progress = StudentProgress::where('user_id', $user->id)
            ->where('sub_topic_id', $subtopicId)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    /**
     * ❌ DIHAPUS: Method ini tidak diperlukan lagi karena MaterialController sudah handle progress
     * Jika masih digunakan, redirect ke MaterialController::updateProgress
     */
    public function storeOrUpdate(Request $request, $materialId)
    {
        // Redirect ke MaterialController
        return app(MaterialController::class)->updateProgress($request, $materialId);
    }

    public function export()
    {
        $fileName = 'student-progress-' . date('Y-m-d-His') . '.csv';
        
        // Query data dengan relasi
        $data = StudentProgress::with(['user', 'subtopic', 'gameCode'])
            ->orderBy('completed_at', 'desc')
            ->get();
        
        // Buat header CSV
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // BOM untuk UTF-8 agar Excel bisa baca karakter Indonesia
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header kolom
            fputcsv($file, [
                'Nama Siswa',
                'NIS',
                'Kelas',
                'Asal Sekolah',
                'Subtopik',
                'Level',
                'Tanggal Selesai',
                'Status'
            ]);
            
            // Data rows
            foreach ($data as $progress) {
                fputcsv($file, [
                    $progress->user->name ?? '-',
                    $progress->user->nis ?? '-',
                    $progress->user->class ?? '-',
                    $progress->user->school ?? '-',
                    $progress->subtopic->title ?? '-',
                    ucfirst($progress->level),
                    $progress->completed_at ? $progress->completed_at->format('d-m-Y H:i:s') : '-',
                    $progress->is_completed ? 'Selesai' : 'Belum Selesai'
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}