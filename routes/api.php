<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Users
    Route::apiResource('users', UserController::class)->except(['store']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Modules
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{id}/activate', [UserController::class, 'activateModule']);
    Route::post('/modules/{id}/deactivate', [UserController::class, 'deactivateModule']);

    // Short links
    Route::get('/links', [ShortLinkController::class, 'index']);
});
