<?php

namespace App\Http\Controllers;

use App\Models\TKA;
use App\Models\TKAAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TKAController extends Controller
{
    public function index()
    {
        $tka = TKA::first();
        
        if (!$tka) {
            return Inertia::render('TKA/Index', [
                'tka' => null,
                'hasAttempt' => false,
                'latestAttempt' => null,
                'error' => 'Belum ada TKA yang tersedia.'
            ]);
        }

        $user = Auth::user();

        $latestAttempt = TKAAnswer::where('user_id', $user->id)
            ->where('t_k_a_id', $tka->id)
            ->latest()
            ->first();

        $hasAttempt = $latestAttempt !== null;

        return Inertia::render('TKA/Index', [
            'tka' => $tka,
            'hasAttempt' => $hasAttempt,
            'latestAttempt' => $latestAttempt,
        ]);
    }

    public function start()
    {
        $tka = TKA::first();
        
        if (!$tka) {
            return redirect()->route('tka.index')
                ->with('error', 'TKA tidak ditemukan.');
        }
        return redirect()->route('tka.show');
    }

    public function show()
    {
        $tka = TKA::first();
        
        if (!$tka) {
            return redirect()->route('tka.index')
                ->with('error', 'TKA tidak ditemukan.');
        }

        return Inertia::render('TKA/Show', [
            'test' => [
                'id' => $tka->id,
                'title' => $tka->title,
                'description' => $tka->description,
                'questions' => $tka->questions ?? [],
            ],
        ]);
    }

    public function submit(Request $request)
    {
        $tka = TKA::first();
        
        if (!$tka) {
            return redirect()->route('tka.index')
                ->with('error', 'TKA tidak ditemukan.');
        }

        $user = Auth::user();

        $data = $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $data['answers'];
        $questions = collect($tka->questions ?? []);

        $correct = 0;
        foreach ($answers as $ans) {
            $q = $questions->firstWhere('id', $ans['question_id']);
            if (!$q) continue;

            $opt = collect($q['options'])->firstWhere('id', $ans['selected_option_id']);
            if ($opt && ($opt['is_correct'] ?? false)) {
                $correct++;
            }
        }

        $totalQuestions = count($questions);
        $wrong = $totalQuestions - $correct;
        $score = round(($correct / max(1, $totalQuestions)) * 100, 2);

        $attempt = TKAAnswer::create([
            't_k_a_id' => $tka->id,
            'user_id' => $user->id,
            'answers' => $answers,
            'score' => $score,
            'correct_count' => $correct,
            'wrong_count' => $wrong,
            'total_questions' => $totalQuestions,
            'submitted_at' => now(),
        ]);

        return redirect()->route('tka.result', $attempt->id)
            ->with('success', "Tes selesai! Skor Anda: {$score}%");
    }

    public function result(TKAAnswer $answer)
    {
        $user = Auth::user();
        $tka = TKA::find($answer->t_k_a_id);
        
        if (!$tka) {
            return redirect()->route('tka.index')
                ->with('error', 'Data TKA tidak ditemukan.');
        }

        // FITUR BARU: Ambil semua attempt user untuk TKA ini
        $allAttempts = TKAAnswer::where('user_id', $user->id)
            ->where('t_k_a_id', $tka->id)
            ->orderBy('submitted_at', 'desc')
            ->get()
            ->map(function($attempt) {
                return [
                    'id' => $attempt->id,
                    'score' => $attempt->score,
                    'submitted_at' => $attempt->submitted_at,
                    'correct_count' => $attempt->correct_count ?? 0,
                    'wrong_count' => $attempt->wrong_count ?? 0,
                ];
            });

        return Inertia::render('TKA/Result', [
            'result' => [
                'id' => $answer->id,
                'score' => $answer->score,
                'submitted_at' => $answer->submitted_at,
                'correct_count' => $answer->correct_count ?? 0,
                'wrong_count' => $answer->wrong_count ?? 0,
                'total_questions' => $answer->total_questions ?? count($tka->questions ?? []),
                'questions' => $tka->questions ?? [],
                'answers' => $answer->answers ?? [],
            ],
            'allAttempts' => $allAttempts,
        ]);
    }
}