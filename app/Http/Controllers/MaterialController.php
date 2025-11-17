<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialSection;
use App\Models\StudentProgress;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Traits\HandlesStudentProgress;

class MaterialController extends Controller
{
    use HandlesStudentProgress;

    /**
     * Daftar materi
     */
    public function index()
    {
        $materials = Material::with('subtopic.topic')
            ->orderBy('id', 'asc')
            ->get();

        return Inertia::render('Material/Index', [
            'materials' => $materials,
        ]);
    }

    /**
     * Tampilkan materi beserta progress & jawaban siswa (DENGAN GRADING)
     */
    // public function show($id)
    // {
    //     $material = Material::with([
    //         'subtopic.topic',
    //         'gameCode',
    //         'sections' => fn($q) => $q->orderBy('order', 'asc'),
    //     ])->findOrFail($id);

    //     $user = Auth::user();

    //     // Semua materi dalam game yang sama
    //     $allMaterials = [];
    //     if ($material->game_code_id) {
    //         $allMaterials = Material::where('game_code_id', $material->game_code_id)
    //             ->orderBy('order', 'asc')
    //             ->get(['id', 'title', 'order']);
    //     }

    //     // Ambil progress
    //     $studentProgress = StudentProgress::where('user_id', $user->id)
    //         ->where('material_id', $material->id)
    //         ->first();

    //     // Ambil jawaban dengan relasi gradedBy
    //     $studentAnswers = StudentAnswer::where('user_id', $user->id)
    //         ->whereIn('material_section_id', $material->sections->pluck('id'))
    //         ->with('gradedBy:id,name')
    //         ->get()
    //         ->groupBy('material_section_id')
    //         ->map(function ($answers) {
    //             return $answers->map(fn($a) => [
    //                 'id' => $a->id,
    //                 'field_name' => $a->field_name,
    //                 'answer_text' => $a->answer_text,
    //                 'answer_file' => $a->answer_file ? Storage::url($a->answer_file) : null,
    //                 'score' => $a->score,
    //                 'feedback' => $a->feedback,
    //                 'graded_at' => $a->graded_at?->toISOString(),
    //                 'graded_by' => $a->gradedBy?->name,
    //             ]);
    //         });
            


    //     $sections = $material->templateSections(); // 


    //     // Gabungkan sections + jawaban
    //     $sectionsWithAnswers = $sections->map(function ($section) use ($studentAnswers) {
    //         return [
    //             ...$section->toArray(),
    //             'student_answers' => $studentAnswers[$section->id] ?? [],
    //         ];
    //     });

    //     return Inertia::render('Material/Show', [
    //         'material' => $material,
    //         'sections' => $sectionsWithAnswers,
    //         'allMaterials' => $allMaterials,
    //         'studentProgress' => $studentProgress ? [
    //             'active_section' => $studentProgress->active_section,
    //             'completed_section' => $studentProgress->completed_section ?? [],
    //             'is_completed' => $studentProgress->is_completed,
    //         ] : null,
    //         'answers' => $studentAnswers,
    //     ]);
    // }

    public function show($id)
{
    $material = Material::with([
        'subtopic.topic',
        'gameCode',
        'sections' => fn($q) => $q->orderBy('order', 'asc'),
    ])->findOrFail($id);

    $user = Auth::user();

    // Semua materi dalam game yang sama
    $allMaterials = [];
    if ($material->game_code_id) {
        $allMaterials = Material::where('game_code_id', $material->game_code_id)
            ->orderBy('order', 'asc')
            ->get(['id', 'title', 'order']);
    }

    // Ambil progress
    $studentProgress = StudentProgress::where('user_id', $user->id)
        ->where('material_id', $material->id)
        ->first();

    // Ambil jawaban dan flatten
    $studentAnswers = StudentAnswer::where('user_id', $user->id)
        ->whereIn('material_section_id', $material->sections->pluck('id'))
        ->with('gradedBy:id,name')
        ->get()
        ->groupBy('material_section_id');

    // Ambil template sections
    $templateSections = $material->templateSections();

    // ➤ GABUNGKAN TEMPLATE + ID ASLI DARI DB
    $sectionsWithAnswers = $templateSections->map(function ($templateSection) use ($material, $studentAnswers) {

        // Cari section DB yang memiliki template_key yang sama
        $dbSection = $material->sections
            ->firstWhere('template_key', $templateSection->template_key);

        // Jika tidak ada, maka tidak akan ada jawaban
        $sectionId = $dbSection?->id;

        return [
            ...$templateSection->toArray(),
            'id' => $sectionId, // ← PENTING! pakai id asli material_sections
            'student_answers' => $sectionId
                ? ($studentAnswers[$sectionId] ?? collect())->values()
                : [],
        ];
    });

    return Inertia::render('Material/Show', [
        'material' => $material,
        'sections' => $sectionsWithAnswers,
        'allMaterials' => $allMaterials,
        'studentProgress' => $studentProgress ? [
            'active_section' => $studentProgress->active_section,
            'completed_section' => $studentProgress->completed_section ?? [],
            'is_completed' => $studentProgress->is_completed,
        ] : null,
    ]);
}


    /**
     * Simpan progress siswa (FIXED: Konsisten dengan frontend)
     */
    // public function updateProgress(Request $request, $id)
    // {
    //     $user = Auth::user();
    //     $material = Material::findOrFail($id);

    //     $validated = $request->validate([
    //         'active_section' => 'required|integer|min:1',
    //         'completed_section' => 'nullable|array',
    //         'is_completed' => 'boolean',
    //     ]);

    //     $existing = StudentProgress::where('user_id', $user->id)
    //         ->where('material_id', $material->id)
    //         ->first();

    //     $newCompleted = $validated['completed_section'] ?? [];
    //     $mergedCompleted = $existing
    //         ? array_values(array_unique(array_merge($existing->completed_section ?? [], $newCompleted)))
    //         : $newCompleted;

    //     // ✅ PERBAIKAN: Total sections = 1 (video) + sections + 1 (tes akhir)
    //     $totalSections = 1 + $material->sections()->count() + 1;

    //     $progressPercent = min(100, round((count($mergedCompleted) / $totalSections) * 100));
    //     $isCompleted = $validated['is_completed'] ?? $progressPercent === 100;

    //     $progress = $this->updateProgressOrCreate([
    //         'user_id' => $user->id,
    //         'sub_topic_id' => $material->sub_topic_id,
    //         'material_id' => $material->id,
    //         'game_code_id' => $material->game_code_id,
    //         'level' => $material->level, // ✅ Simpan level
    //         'active_section' => $validated['active_section'],
    //         'completed_section' => $mergedCompleted,
    //         'progress_percent' => $progressPercent,
    //         'is_completed' => $isCompleted,
    //         'completed_at' => $isCompleted ? now() : null,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Progress berhasil diperbarui',
    //         'data' => $progress,
    //     ]);
    // }

    public function updateProgress(Request $request, $id)
    {
        $user = Auth::user();
        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'active_section' => 'required|integer|min:1',
            'completed_section' => 'nullable|array',
            'is_completed' => 'boolean',
        ]);

        // ✅ Ambil sections dari template baru
        $sections = $material->templateSections();

        // ✅ Total steps = Video (1) + Sections + Final Test (1)
        $totalSections = 1 + $sections->count() + 1;

        // ✅ Pastikan active_section tidak melebihi total
        $active = min($validated['active_section'], $totalSections);

        // ✅ Ambil existing progress
        $existing = StudentProgress::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->first();

        // ✅ Gabungkan completed_section dan filter supaya tidak keluar batas
        $newCompleted = $validated['completed_section'] ?? [];
        $mergedCompleted = $existing
            ? array_values(array_unique(array_merge($existing->completed_section ?? [], $newCompleted)))
            : $newCompleted;

        $mergedCompleted = collect($mergedCompleted)
            ->filter(fn($x) => $x >= 1 && $x <= $totalSections)
            ->values()
            ->toArray();

        // ✅ Hitung progress%
        $progressPercent = min(100, round((count($mergedCompleted) / $totalSections) * 100));

        // ✅ Tentukan selesai atau belum
        $isCompleted = $validated['is_completed'] ?? ($progressPercent === 100);

        // ✅ Simpan progress
        $progress = StudentProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'material_id' => $material->id,
            ],
            [
                'sub_topic_id' => $material->sub_topic_id,
                'game_code_id' => $material->game_code_id,
                'level' => $material->level,
                'active_section' => $active,
                'completed_section' => $mergedCompleted,
                'progress_percent' => $progressPercent,
                'is_completed' => $isCompleted,
                'completed_at' => $isCompleted ? now() : null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress berhasil diperbarui',
            'data' => $progress,
        ]);
    }

    /**
     * Simpan jawaban siswa
     */
    public function saveAnswer(Request $request, $sectionId)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'field_name' => 'nullable|string',
            'answer_text' => 'nullable|string',
            'answer_file' => 'nullable|file|max:20480',
        ]);

        $section = MaterialSection::findOrFail($sectionId);

        $filePath = null;
        if ($request->hasFile('answer_file')) {
            $existingAnswer = StudentAnswer::where('user_id', $user->id)
                ->where('material_section_id', $section->id)
                ->where('field_name', $validated['field_name'] ?? 'default')
                ->first();

            if ($existingAnswer && $existingAnswer->answer_file) {
                Storage::disk('public')->delete($existingAnswer->answer_file);
            }

            $filePath = $request->file('answer_file')->store('student_answers', 'public');
        }

        $answer = StudentAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'material_section_id' => $section->id,
                'field_name' => $validated['field_name'] ?? 'default',
            ],
            [
                'answer_text' => $validated['answer_text'] ?? null,
                'answer_file' => $filePath ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan.',
            'data' => [
                'id' => $answer->id,
                'field_name' => $answer->field_name,
                'answer_text' => $answer->answer_text,
                'answer_file' => $answer->answer_file ? Storage::url($answer->answer_file) : null,
                'score' => $answer->score,
                'feedback' => $answer->feedback,
                'graded_at' => $answer->graded_at?->toISOString(),
                'graded_by' => $answer->gradedBy?->name,
            ],
        ]);
    }
}