<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::post('/tasks', [TaskController::class, 'store']);

Route::get('/categories', [TaskController::class, 'getCategories']);
