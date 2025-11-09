<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{

    public function topics()
    {
        return Inertia::render('student/TopicList');
    }

    public function subtopics($id)
    {
        return Inertia::render('student/SubtopicList', ['topicId' => (int)$id]);
    }

    public function game($id)
    {
        return Inertia::render('student/GamePlay', ['subtopicId' => (int)$id]);
    }

    public function material($id)
    {
        return Inertia::render('student/MaterialPage', ['subtopicId' => (int)$id]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}