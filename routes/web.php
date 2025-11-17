<?php

use App\Http\Controllers\FinalTestController;
use App\Http\Controllers\StudentProgressController;
use App\Http\Controllers\GameCodeController;
use App\Http\Controllers\LearningVideoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\StudentAnswerController;
use App\Http\Controllers\SubTopicController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TKAController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('auth/login');
})->name('home');

 Route::get('/games/line', function () {
        return Inertia::render('games/LineJump');
    })->name('line');

Route::middleware(['auth:web', 'role:teacher,admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // Tambahkan semua route admin kamu di sini
});

Route::middleware(['auth:web', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [StudentProgressController::class, 'index'])->name('home');

    // Topics
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');

    // Subtopics
    Route::get('/topics/{topic}/subtopics', [SubTopicController::class, 'index'])->name('subtopics.index');

    // Game routes
    Route::get('/subtopics/{subtopic}/game', [GameCodeController::class, 'play'])->name('game.play');
    Route::post('/subtopics/{subtopic}/verify', [GameCodeController::class, 'verify'])->name('game.verify');
    Route::post('/game/verify/{subtopic}', [GameCodeController::class, 'verifyAndAccess'])->name('game.verifyAndAccess');
    Route::post('/game/store-code', [GameCodeController::class, 'store'])
    ->middleware(['auth'])
    ->name('game.store.code');

    // Materials
    Route::resource('materials', MaterialController::class)->only(['index', 'show']);

    // Student Progress
    Route::post('/materials/{material}/progress', [MaterialController::class, 'updateProgress'])
        ->name('materials.progress.update');

    // Student Answers (for material sections)
    Route::post('/student-answers', [StudentAnswerController::class, 'store'])->name('student-answers.store');

    // ✅ Final Test Routes
    Route::post('/final-test/start/{material}', [FinalTestController::class, 'start'])->name('final-test.start');
    Route::post('/final-test/save-answer/{attemptId}/{questionId}', [FinalTestController::class, 'saveAnswer']);

    Route::post('/final-test/submit/{attemptId}', [FinalTestController::class, 'submit'])
        ->name('final-test.submit');

    Route::get('/tka', [TKAController::class, 'index'])->name('tka.index');
    Route::post('/tka/start', [TKAController::class, 'start'])->name('tka.start');
    Route::get('/tka/show', [TKAController::class, 'show'])->name('tka.show');
    Route::post('/tka/submit', [TKAController::class, 'submit'])->name('tka.submit');
    Route::get('/tka/result/{answer}', [TKAController::class, 'result'])->name('tka.result');

    // Learning Videos
    Route::get('/learning-videos', action: [LearningVideoController::class, 'index'])->name('learning-videos.index');

    Route::get('profile', function () {
        return Inertia::render('Profile/Index');
    })->name('profile');

    Route::post('/profile/update', [ProfileUpdateController::class, 'update'])->name('profile.update');

    Route::get('/our-team', [TeamsController::class, 'index'])->name('team.index');
Route::get('/our-team/{team:slug}', [TeamsController::class, 'show'])->name('team.show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';