<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\GameCode;
use App\Models\SubTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $topics = Topic::with('subTopics')->get();
        
    //     return Inertia::render('materials/Index', [
    //         'topics' => $topics
    //     ]);
    // }

    public function index()
    {
        $topics = Topic::select('id', 'title', 'description')->get();

        return Inertia::render('Topics/Index', [
            'topics' => $topics,
        ]);
    }

    /**
     * Menampilkan detail 1 topik berdasarkan ID.
     */
    public function show($id): JsonResponse
    {
        $topic = Topic::with('subtopics')->find($id);

        if (!$topic) {
            return response()->json([
                'success' => false,
                'message' => 'Topik tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $topic
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(Topic $topic, $id)
    // {
    //     $topic = Topic::findOrFail($id);

    //     return Inertia::render('Materials/Show', [
    //         'topic' => $topic,
    //         'materials' => [],
    //         'level' => null,
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        //
    }

    public function verify(Request $request, $id)
    {
        $request->validate(['code' => 'required|string']);
        $topic = Topic::findOrFail($id);
        $code = GameCode::where('code', $request->code)->first();

        if (!$code) {
            return back()->withErrors(['code' => 'Kode akses tidak valid.']);
        }

        $materials = SubTopic::where('topic_id', $id)
            ->where('level', $code->level)
            ->get();

        return Inertia::render('materials/Show', [
            'topic' => $topic,
            'materials' => $materials,
            'level' => $code->level,
        ]);
    }
}