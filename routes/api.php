<?php

use App\Http\Controllers\GameCodeController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/topics', [TopicController::class, 'index']);
Route::post('/verify-code', [GameCodeController::class, 'verify']);

?>