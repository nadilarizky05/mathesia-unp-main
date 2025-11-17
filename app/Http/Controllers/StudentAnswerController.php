<?php

namespace App\Http\Controllers;

use App\Models\StudentAnswer;
use App\Http\Requests\StoreStudentAnswerRequest;
use App\Http\Requests\UpdateStudentAnswerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class StudentAnswerController extends Controller
{
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
     public function store(Request $request)
    {
        $validated = $request->validate([
            'material_section_id' => 'required|exists:material_sections,id',
            'field_name' => 'required|string',
            'answer_text' => 'nullable|string',
            'answer_file' => 'nullable|file|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('answer_file')) {
            $filePath = $request->file('answer_file')->store('answers', 'public');
        }

        $answer = StudentAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'material_section_id' => $validated['material_section_id'],
                'field_name' => $validated['field_name'],
            ],
            [
                'answer_text' => $validated['answer_text'] ?? null,
                'answer_file' => $filePath,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $answer,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentAnswerRequest $request, StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAnswer $studentAnswer)
    {
        //
    }

    /**
     * Export student answers to CSV
     */
    public function export()
    {
        $user = Auth::user();
        $fileName = 'kumpulan-jawaban-siswa-' . date('Y-m-d-His') . '.csv';
        
        // Query data dengan relasi dan filter berdasarkan role
        $query = StudentAnswer::with(['user', 'section.material']);
        
        // ✅ Filter untuk teacher: hanya siswa dari sekolah yang sama
        if ($user->role === 'teacher') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('school', $user->school);
            });
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
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
                'Section Materi',
                'Nama Materi',
                'Field Nama',
                'Jawaban Text',
                'File Jawaban',
                'Nilai',
                'Tanggal Dibuat',
                'Tanggal Update'
            ]);
            
            // Data rows
            foreach ($data as $answer) {
                fputcsv($file, [
                    $answer->user->name ?? '-',
                    $answer->user->nis ?? '-',
                    $answer->user->class ?? '-',
                    $answer->user->school ?? '-',
                    $answer->section->title ?? '-',
                    $answer->section->material->title ?? '-',
                    $answer->field_name ?? '-',
                    $answer->answer_text ?? '-',
                    $answer->answer_file ? 'Ada File' : 'Tidak Ada',
                    $answer->score ?? 'Belum Dinilai',
                    $answer->created_at ? $answer->created_at->format('d-m-Y H:i:s') : '-',
                    $answer->updated_at ? $answer->updated_at->format('d-m-Y H:i:s') : '-'
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}