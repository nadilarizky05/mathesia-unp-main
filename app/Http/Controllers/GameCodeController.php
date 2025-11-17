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

        // Ambil progress user pada subtopik ini
        $progress = StudentProgress::where('user_id', $user->id)
            ->where('sub_topic_id', $subtopicId)
            ->whereNotNull('game_code_id')
            ->first();

        if ($progress) {

            // Ambil materi berdasarkan game_code yang dipilih user
            $material = Material::where('game_code_id', $progress->game_code_id)->first();

            if ($progress->is_completed && $material) {
                return redirect()
                    ->route('materials.show', ['material' => $material->id])
                    ->with('info', 'Kamu sudah menyelesaikan game ini. Langsung ke materi.');
            }

            if ($material) {
                return redirect()
                    ->route('materials.show', ['material' => $material->id])
                    ->with('info', 'Lanjutkan materi dari bagian terakhir.');
            }
        }

        // User belum punya progress → tampilkan halaman game
        return inertia('Game/Play', [
            'subtopic' => $subtopic,
            'game_url' => null,
            'level' => null,
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_topic_id' => 'required|exists:sub_topics,id',
            'code' => 'required|string|max:6|unique:game_codes,code',
            'level' => 'required|in:inferior,reguler,superior',
        ]);

        // 1. Simpan GameCode
        $gameCode = GameCode::create([
            'sub_topic_id' => $validated['sub_topic_id'],
            'code' => strtoupper($validated['code']),
            'level' => strtolower($validated['level']),
        ]);

        // 2. Tentukan TITLE berdasarkan subtopic
        $titles = [
            1 => "Pola Bilangan",
            2 => "Koordinat Kartesius",
            3 => "Relasi Fungsi", 
            4 => "Persamaan Garis",
            5 => "SPLDV",
            6 => "Pythagoras",
            7 => "Lingkaran",
            8 => "Garis Singgung Lingkarang",
            9 => "Bangun Ruang Sisi Datar",
            10 => "Bangun Ruang Sisi Lengkung",
            // kalau nanti ada subtopic tambahan
        ];

        $title = $titles[$validated['sub_topic_id']] . " (" . ucfirst($validated['level']) . ")";

        // 3. Tentukan ORDER berdasarkan LEVEL
        $order = match ($validated['level']) {
            'inferior' => 1,
            'reguler' => 2,
            'superior' => 3,
        };

        $videos = [
            1 => 'https://www.youtube.com/embed/SIM-LFgrQus?si=OGyECtwdu8reiip5',
            2 => 'https://www.youtube.com/embed/E2f95LsDSio?si=JWj7RaKKZMN_rTaF',
            3 => 'https://www.youtube.com/embed/fsZj7CsZPRI?si=QuvKUeCgHjNK136f',
            4 => 'https://www.youtube.com/embed/G9kp4yq92Xc?si=URzlgyNVm8M32emO',
            5 => 'https://www.youtube.com/embed/B5PaFOJ8Png?si=dNXGUqPbkQy9yUuV',
            6 => 'https://www.youtube.com/embed/NoLsDwkNbVs?si=ZaQWphQK7GY2D-6q',
            7 => 'https://www.youtube.com/embed/_wjOho8khio?si=SmHk9CLBH27bRJL9',
            8 => 'https://www.youtube.com/embed/mbqs4O538P8?si=qvFpvnQ_HQZXaeie',
            9 => 'https://www.youtube.com/embed/IIB9rAOGmhY?si=rSoSz3QNFSsC5FLn',
            10 => 'https://www.youtube.com/embed/VjvzF9gEgww?si=p4KiSh6vswSJI7IW',
        ];

        $videoUrl = $videos[$request->sub_topic_id] ?? null;

        // 4. Buat MATERIAL otomatis
        Material::create([
            'sub_topic_id' => $validated['sub_topic_id'],
            'title' => $title,
            'level' => $validated['level'],
            'content' => null,
            'file_url' => null,
            'video_url' => $videoUrl, // nanti bisa diisi otomatis juga
            'order' => $order,
            'game_code_id' => $gameCode->id,
        ]);

        return back()->with('success', 'Kode game berhasil disimpan sebagai data baru.');
        
    }
}