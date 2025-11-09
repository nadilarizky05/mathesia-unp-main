<?php

namespace App\Http\Controllers;

use App\Models\StudentAnswer;
use App\Http\Requests\StoreStudentAnswerRequest;
use App\Http\Requests\UpdateStudentAnswerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}