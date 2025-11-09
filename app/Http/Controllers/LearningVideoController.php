<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningVideoController extends Controller
{
    /**
     * Display all materials that have video URLs.
     */
    public function index()
    {
        $videos = Material::whereNotNull('video_url')
            ->select('id', 'title', 'video_url', 'level', 'order')
            ->orderBy('order')
            ->get();

        return Inertia::render('Video/Index', [
            'videos' => $videos,
        ]);
    }
}