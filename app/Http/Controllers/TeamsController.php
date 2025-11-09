<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use App\Http\Requests\StoreTeamsRequest;
use App\Http\Requests\UpdateTeamsRequest;
use Inertia\Inertia;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Teams::with('members')->orderBy('name')->get(['id','name','slug','description']);
        
        // Tambahkan full URL untuk avatar
        $teams->each(function ($team) {
            $team->members->each(function ($member) {
                if ($member->avatar_url) {
                    $member->avatar_url = asset('storage/' . $member->avatar_url);
                }
            });
        });
        
        return Inertia::render('Team/Index', [
            'teams' => $teams,
        ]);
    }

    public function show(Teams $teams)
    {
        $teams->load('members');
        
        // Tambahkan full URL untuk avatar
        $teams->members->each(function ($member) {
            if ($member->avatar_url) {
                $member->avatar_url = asset('storage/' . $member->avatar_url);
            }
        });
        
        return Inertia::render('Team/Show', [
            'team' => $teams,
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
    public function store(StoreTeamsRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teams $teams)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamsRequest $request, Teams $teams)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teams $teams)
    {
        //
    }
}