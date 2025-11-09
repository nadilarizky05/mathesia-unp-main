<?php

use App\Http\Controllers\GameCodeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SubTopicController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/topics', [TopicController::class, 'index']);
    Route::get('/topics/{id}/subtopics', [SubTopicController::class, 'getByTopic']);

    Route::get('/subtopics/{id}/game', [GameCodeController::class, 'getGameBySubtopic']);
    Route::post('/subtopics/{id}/verify', [GameCodeController::class, 'verifyGameCode']);

    Route::middleware('verify.game')->get('/materials/{subtopic_id}', [MaterialController::class, 'getBySubtopic']);
});

?>