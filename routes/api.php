<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class)->except(['store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{id}/activate', [UserController::class, 'activateModule']);
});
