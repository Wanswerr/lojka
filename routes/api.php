<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAuthController; // Importe o controller

// Rota de login para o admin
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Rotas protegidas por autenticação Sanctum para o guarda 'admin'
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::get('/admin/me', [AdminAuthController::class, 'me']);
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
});