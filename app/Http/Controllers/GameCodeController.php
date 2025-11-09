<?php

namespace App\Http\Controllers;

use App\Models\GameCode;
use App\Http\Requests\StoreGameCodeRequest;
use App\Http\Requests\UpdateGameCodeRequest;
use App\Models\Material;
use App\Models\StudentProgress;
use App\Models\SubTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Traits\HandlesStudentProgress;


class GameCodeController extends Controller
{
    use HandlesStudentProgress;


    public function play($subtopicId)
    {
        $user = Auth::user();
        $subtopic = SubTopic::with('materials')->findOrFail($subtopicId);

        // Ambil game yang terkait dengan subtopic
        $game = GameCode::where('sub_topic_id', $subtopicId)->first();

        // Cek progress user
        $progress = StudentProgress::where('user_id', $user->id)
            ->where('sub_topic_id', $subtopicId)
            ->first();

        if ($progress) {
            if ($progress->is_completed && $subtopic->materials->isNotEmpty()) {
                return redirect()
                    ->route('materials.show', ['material' => $subtopic->materials->first()->id])
                    ->with('info', 'Kamu sudah menyelesaikan game ini. Langsung ke materi.');
            }

            if ($subtopic->materials->isNotEmpty()) {
                return redirect()
                    ->route('materials.show', ['material' => $subtopic->materials->first()->id])
                    ->with('info', 'Lanjutkan materi dari bagian terakhir.');
            }
        }

        // ⬇️ Tambahkan game_url ke props
        return inertia('Game/Play', [
            'subtopic' => $subtopic,
            'game_url' => $game?->game_url, // gunakan null-safe operator
            'level' => $game?->level,
        ]);
    }



    public function verify(Request $request, $subtopicId)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $gameCode = GameCode::where('code', $validated['code'])
            ->where('sub_topic_id', $subtopicId)
            ->first();

        if (!$gameCode) {
            return back()->withErrors(['code' => 'Kode salah.']);
        }

        // Tandai progress siswa
        StudentProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'sub_topic_id' => $subtopicId],
            ['is_completed' => true]
        );

        // Redirect inertia ke halaman material
        $subtopic = SubTopic::findOrFail($subtopicId);
        return redirect()->route('materials.show', $subtopic->material_id)
            ->with('success', 'Kode berhasil diverifikasi!');
    }

    public function verifyAndAccess(Request $request, $subtopicId)
{
    $request->validate([
        'access_code' => 'required|string|max:6',
    ]);

    $code = strtoupper($request->access_code);

    $gameCode = GameCode::where('code', $code)
        ->where('sub_topic_id', $subtopicId)
        ->first();

    if (!$gameCode) {
        return back()->withErrors(['access_code' => 'Kode tidak valid atau tidak cocok dengan subtopik ini.']);
    }

    $material = Material::where('game_code_id', $gameCode->id)->first();

    if (!$material) {
        return back()->withErrors(['access_code' => 'Belum ada materi yang terhubung dengan kode ini.']);
    }

    // ✅ Simpan progress tanpa duplikasi
    $this->updateProgressOrCreate([
        'user_id' => Auth::id(),
        'sub_topic_id' => $subtopicId,
        'game_code_id' => $gameCode->id,
        'material_id' => $material->id,
        'is_completed' => true,
        'completed_at' => now(), 
        'level' => $gameCode->level
    ]);

    return redirect()
        ->route('materials.show', ['material' => $material->id])
        ->with('success', 'Kode berhasil diverifikasi! Kamu bisa mulai belajar.');
}

    public function getGameBySubtopic($subtopicId): JsonResponse
    {
        $game = GameCode::where('sub_topic_id', $subtopicId)
            ->select('id', 'sub_topic_id', 'game_url', 'code')
            ->first();

        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Game untuk subtopik ini belum tersedia.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $game
        ]);
    }

    /**
     * Verifikasi kode yang dimasukkan siswa.
     */
    public function verifyGameCode(Request $request, $subtopicId): JsonResponse
    {
        $user = Auth::user();
        $code = $request->input('code');

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tidak boleh kosong.'
            ], 400);
        }

        $game = GameCode::where('sub_topic_id', $subtopicId)
            ->where('code', $code)
            ->first();



        if (!$game) {
            return response()->json([
                'success' => false,
                'message' => 'Kode salah atau tidak valid.'
            ], 400);
        }

        // Simpan progress siswa
        StudentProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'sub_topic_id' => $subtopicId,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Kode valid! Kamu bisa mengakses materi.',
            'data' => [
                'sub_topic_id' => $subtopicId,
                'game_code' => $code,
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreGameCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GameCode $gameCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameCode $gameCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameCodeRequest $request, GameCode $gameCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameCode $gameCode)
    {
        //
    }
}