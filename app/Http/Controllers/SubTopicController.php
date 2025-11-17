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

            // Ambil progress tertinggi untuk subtopic ini
            $progressPercent = StudentProgress::where('user_id', $user->id)
                ->where('sub_topic_id', $subtopic->id)
                ->max('progress_percent') ?? 0;

            return [
                'id' => $subtopic->id,
                'title' => $subtopic->title,
                'description' => $subtopic->description ?? '',
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
