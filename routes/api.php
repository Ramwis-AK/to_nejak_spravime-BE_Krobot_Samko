<?php

use App\Http\Controllers\Api\NovinkaController;
use App\Http\Controllers\Api\StartupController;
use App\Http\Controllers\Api\PraxController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\KontaktController;
use App\Http\Controllers\Api\VyzvaController;
use Illuminate\Support\Facades\Route;

// ---- Verejné read-only endpointy ----
Route::get('/novinky', [NovinkaController::class, 'index']);
Route::get('/novinky/{novinka}', [NovinkaController::class, 'show']);

Route::get('/startups', [StartupController::class, 'index']);
Route::get('/startups/{startup}', [StartupController::class, 'show']);

Route::get('/praxe', [PraxController::class, 'index']);
Route::get('/praxe/{prax}', [PraxController::class, 'show']);

Route::get('/partneri', [PartnerController::class, 'index']);
Route::get('/mentori', [MentorController::class, 'index']);

Route::get('/vyzvy', [VyzvaController::class, 'index']);
Route::get('/vyzvy/{vyzva}', [VyzvaController::class, 'show']);

Route::post('/kontakt', [KontaktController::class, 'store'])->middleware('throttle:5,1');
