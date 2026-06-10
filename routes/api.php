<?php

use App\Http\Controllers\Api\NovinkaController;
use Illuminate\Support\Facades\Route;

// ---- Verejné read-only endpointy ----
Route::get('/novinky', [NovinkaController::class, 'index']);
Route::get('/novinky/{novinka}', [NovinkaController::class, 'show']);