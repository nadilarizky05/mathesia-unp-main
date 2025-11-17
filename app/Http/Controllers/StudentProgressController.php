<?php

namespace App\Http\Controllers;

use App\Models\StudentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentProgressController extends Controller
{
    /**
     * Tampilkan progres user login di halaman Home (agregasi per SubTopic)
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil progres, kumpulkan per subtopic, dan ambil progress tertinggi
        $progress = StudentProgress::with(['subTopic.topic', 'gameCode', 'material'])
            ->where('user_id', $user->id)
            ->selectRaw('sub_topic_id, MAX(progress_percent) as progress_percent')
            ->groupBy('sub_topic_id')
            ->get()
            ->map(function ($item) use ($user) {

                // Ambil record detail terbaru untuk subtopic itu
                $latest = StudentProgress::with(['material', 'gameCode'])
                    ->where('user_id', $user->id)
                    ->where('sub_topic_id', $item->sub_topic_id)
                    ->latest()
                    ->first();

                return [
                    'id' => $item->sub_topic_id,
                    'sub_topic' => [
                        'id' => $latest->subTopic->id,
                        'title' => $latest->subTopic->title,
                        'topic' => $latest->subTopic->topic ? [
                            'id' => $latest->subTopic->topic->id,
                            'title' => $latest->subTopic->topic->title,
                        ] : null,
                    ],
                    'material' => $latest->material ? [
                        'id' => $latest->material->id,
                        'title' => $latest->material->title,
                    ] : null,
                    'game_code' => $latest->gameCode ? [
                        'id' => $latest->gameCode->id,
                        'code' => $latest->gameCode->code,
                    ] : null,
                    'level' => $latest->level ?? 'inferior',
                    'progress_percent' => (int) $item->progress_percent,
                    'is_completed' => (int) $item->progress_percent >= 100,
                    'completed_at' => (int) $item->progress_percent >= 100 ? $latest->updated_at : null,
                ];
            });

        return Inertia::render('Home', [
            'studentProgress' => $progress,
        ]);
    }

    /**
     * Ambil progres user berdasarkan subtopic (untuk detail subtopic / lanjut belajar)
     */
    public function show($subtopicId)
    {
        $user = Auth::user();

        $progress = StudentProgress::where('user_id', $user->id)
            ->where('sub_topic_id', $subtopicId)
            ->orderBy('updated_at', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $progress,
        ]);
    }

    /**
     * Store/update progress sebenarnya ditangani MaterialController, jadi tinggal redirect
     */
    public function storeOrUpdate(Request $request, $materialId)
    {
        return app(MaterialController::class)->updateProgress($request, $materialId);
    }
}