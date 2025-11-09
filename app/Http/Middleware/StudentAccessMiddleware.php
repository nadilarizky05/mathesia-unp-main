<?php

namespace App\Http\Middleware;

use App\Models\GameCode;
use App\Models\StudentProgress;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $subtopicId = $request->route('subtopic_id'); // atau sesuaikan parameter route kamu
        $gameCode = $request->input('code');

        // Jika user belum input code
        if (!$gameCode) {
            return response()->json([
                'message' => 'Kode game diperlukan untuk mengakses materi.'
            ], 403);
        }

        // Cek apakah kode valid
        $code = GameCode::where('code', $gameCode)
            ->where('subtopic_id', $subtopicId)
            ->first();

        if (!$code) {
            return response()->json([
                'message' => 'Kode game tidak valid untuk subtopik ini.'
            ], 403);
        }

        // Simpan progress siswa
        StudentProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'subtopic_id' => $subtopicId,
            ],
            ['completed' => true]
        );

        return $next($request);
    
    }
}