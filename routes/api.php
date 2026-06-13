<?php

use App\Http\Controllers\Api\NovinkaController;
use App\Http\Controllers\Api\StartupController;
use App\Http\Controllers\Api\PraxController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\MentorController;
use App\Http\Controllers\Api\KontaktController;
use App\Http\Controllers\Api\VyzvaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ZadanieController;
use App\Http\Controllers\Api\TimController;
use App\Http\Controllers\Api\PrihlaskaController;
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

// ---- Verejný zápis + rate limiting ----
Route::post('/kontakt', [KontaktController::class, 'store'])->middleware('throttle:5,1');

// ---- Auth (verejné, s rate limitom proti brute-force) ----
Route::post('/auth/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

// ---- Chránené endpointy (vyžadujú Sanctum token) ----
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/verify/{token}', [AuthController::class, 'verify']);
    Route::put('/profil', [ProfileController::class, 'update']);

    // FIRMA — zadania (CRUD)
    Route::get('/zadania', [ZadanieController::class, 'index']);
    Route::post('/zadania', [ZadanieController::class, 'store']);
    Route::put('/zadania/{zadanie}', [ZadanieController::class, 'update']);
    Route::delete('/zadania/{zadanie}', [ZadanieController::class, 'destroy']);

    // VEDÚCI — tím
    Route::get('/timy/moj', [TimController::class, 'moj']);
    Route::post('/timy', [TimController::class, 'store']);
    Route::post('/timy/{tim}/clenovia', [TimController::class, 'addClen']);

    // MENTOR — tímy a míľniky
    Route::get('/timy/mentor', [TimController::class, 'mentorTimy']);
    Route::post('/timy/{tim}/mentor', [TimController::class, 'joinMentor']);
    Route::post('/timy/{tim}/milniky', [TimController::class, 'addMilnik']);
    Route::patch('/timy/{tim}/milniky/{milnik}', [TimController::class, 'approveMilnik']);

    // ŠTUDENT / VEDÚCI — prihlášky
    Route::get('/prihlasky', [PrihlaskaController::class, 'index']);
    Route::post('/prihlasky', [PrihlaskaController::class, 'store']);
});