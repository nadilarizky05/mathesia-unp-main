<?php

namespace App\Http\Controllers;

use App\Models\SubTopic;
use App\Models\StudentProgress;
use App\Models\Topic;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SubTopicController extends Controller
{
    /**
     * Tampilkan semua subtopik dengan progress sesuai level siswa saat ini.
     */
    public function index($topicId)
    {
        $user = Auth::user();
        $topic = Topic::findOrFail($topicId);

        // Ambil semua subtopik berdasarkan topik
        $subtopics = SubTopic::where('topic_id', $topicId)->get();

        // Proses setiap subtopic
        $subtopics = $subtopics->map(function ($subtopic) use ($user) {
            // Cari material mana yang sedang dipelajari user untuk subtopic ini
            $currentProgress = StudentProgress::where('user_id', $user->id)
                ->whereHas('material', function ($query) use ($subtopic) {
                    $query->where('sub_topic_id', $subtopic->id);
                })
                ->orderBy('updated_at', 'desc')
                ->first();

            // Tentukan level yang aktif (default: inferior jika belum ada progress)
            $activeLevel = $currentProgress && $currentProgress->material 
                ? $currentProgress->material->level 
                : 'inferior';

            // Ambil material sesuai level aktif
            $material = Material::where('sub_topic_id', $subtopic->id)
                ->where('level', $activeLevel)
                ->first();

            // Jika tidak ada material dengan level tersebut, ambil inferior
            if (!$material) {
                $material = Material::where('sub_topic_id', $subtopic->id)
                    ->where('level', 'inferior')
                    ->first();
            }

            // Hitung progress untuk material aktif ini
            $progressPercent = 0;
            if ($material) {
                $totalSections = 1 + $material->sections()->count() + 1; // video + sections + tes akhir
                
                $progress = StudentProgress::where('user_id', $user->id)
                    ->where('material_id', $material->id)
                    ->first();

                $completedSections = $progress ? count($progress->completed_section ?? []) : 0;
                $progressPercent = $totalSections > 0
                    ? min(100, round(($completedSections / $totalSections) * 100))
                    : 0;
            }

            return [
                'id' => $subtopic->id,
                'title' => $subtopic->title,
                'description' => $subtopic->description ?? '',
                'level' => $activeLevel,
                'thumbnail' => $subtopic->thumbnail_url
                    ? asset('storage/' . ltrim(str_replace('storage/', '', $subtopic->thumbnail_url), '/'))
                    : null,
                'progress_percent' => $progressPercent,
            ];
        });

        return Inertia::render('Subtopics/Index', [
            'topic' => [
                'id' => $topic->id,
                'title' => $topic->title,
            ],
            'subtopics' => $subtopics,
        ]);
    }

    /**
     * Ambil subtopik (versi JSON) berdasarkan topic_id.
     */
    public function getByTopic($topicId): JsonResponse
    {
        $subtopics = SubTopic::where('topic_id', $topicId)
            ->select('id', 'title', 'description', 'thumbnail_url', 'game_url')
            ->get()
            ->map(function ($subtopic) {
                return [
                    'id' => $subtopic->id,
                    'title' => $subtopic->title,
                    'description' => $subtopic->description,
                    'thumbnail' => $subtopic->thumbnail_url
                        ? asset('storage/' . ltrim(str_replace('storage/', '', $subtopic->thumbnail_url), '/'))
                        : null,
                    'game_url' => $subtopic->game_url,
                ];
            });

        if ($subtopics->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Subtopik tidak ditemukan untuk topik ini.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subtopics,
        ]);
    }

    /**
     * Ambil progress user berdasarkan subtopic yang sudah dimainkan.
     */
    public function progressByUser(): JsonResponse
    {
        $user = Auth::user();

        $progress = StudentProgress::with(['subtopic.topic'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }
}