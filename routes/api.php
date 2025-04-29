<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::post('/task', [TaskController::class, 'submit']);
Route::get('/task/{task_id}/status', [TaskController::class, 'status']);
Route::get('/task/{task_id}/result', [TaskController::class, 'result']);
