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
use App\Http\Controllers\Api\DokumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SpravaController;
use App\Http\Controllers\Api\RozpocetController;
use App\Http\Controllers\Api\KonzultaciaController;
use App\Http\Controllers\Api\AuditController;

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
Route::get('/auth/verify/{token}', [AuthController::class, 'verify']);

// ---- Chránené endpointy (vyžadujú Sanctum token) ----
    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::put('/profil', [ProfileController::class, 'update']);

    Route::get('/dokumenty', [DokumentController::class, 'index']);
    Route::post('/dokumenty', [DokumentController::class, 'store']);
    Route::get('/dokumenty/{dokument}/stiahnut', [DokumentController::class, 'download']);
    Route::delete('/dokumenty/{dokument}', [DokumentController::class, 'destroy']);
    Route::get('/firma/dokumenty/{dokument}/stiahnut', [DokumentController::class, 'firmaStiahnut']);

    // FIRMA — zadania (CRUD)
    Route::get('/zadania', [ZadanieController::class, 'index']);
    Route::post('/zadania', [ZadanieController::class, 'store']);
    Route::put('/zadania/{kod}', [ZadanieController::class, 'update']);
    Route::delete('/zadania/{kod}', [ZadanieController::class, 'destroy']);
    
    Route::get('/firma/prihlasky', [PrihlaskaController::class, 'firemne']);
    Route::patch('/prihlasky/{prihlaska}/stav', [PrihlaskaController::class, 'rozhodnut']);
    // FIRMA — rozpočet (dokumenty využívajú existujúce /dokumenty)
    Route::get('/rozpocet', [RozpocetController::class, 'show']);
    Route::put('/rozpocet', [RozpocetController::class, 'update']);


    // VEDÚCI — tím
    Route::get('/timy/moj', [TimController::class, 'moj']);
    Route::post('/timy', [TimController::class, 'store']);
    Route::post('/timy/{tim}/clenovia', [TimController::class, 'addClen']);
    Route::delete('/timy/{tim}', [TimController::class, 'destroy']);


    // MENTOR — tímy a míľniky
    Route::get('/timy/mentor', [TimController::class, 'mentorTimy']);
    Route::post('/timy/{tim}/mentor', [TimController::class, 'joinMentor']);
    Route::post('/timy/{tim}/milniky', [TimController::class, 'addMilnik']);
    Route::patch('/timy/{tim}/milniky/{milnik}', [TimController::class, 'approveMilnik']);
    // MENTOR — zápisy z konzultácií
    Route::post('/timy/{tim}/konzultacie', [KonzultaciaController::class, 'store']);

    // ŠTUDENT / VEDÚCI — prihlášky
    Route::get('/prihlasky', [PrihlaskaController::class, 'index']);
    Route::post('/prihlasky', [PrihlaskaController::class, 'store']);

    // ADMIN — výzvy CRUD
    Route::post('/vyzvy', [VyzvaController::class, 'store']);
    Route::put('/vyzvy/{vyzva}', [VyzvaController::class, 'update']);
    Route::delete('/vyzvy/{vyzva}', [VyzvaController::class, 'destroy']);
    // ADMIN — prihlášky + audit
    Route::get('/admin/prihlasky', [PrihlaskaController::class, 'adminVsetky']);
    Route::patch('/admin/prihlasky/{prihlaska}/stav', [PrihlaskaController::class, 'adminStav']);
    Route::get('/admin/audit', [AuditController::class, 'index']);
    // ADMIN — novinky CRUD
    Route::post('/novinky', [NovinkaController::class, 'store']);
    Route::put('/novinky/{novinka}', [NovinkaController::class, 'update']);
    Route::delete('/novinky/{novinka}', [NovinkaController::class, 'destroy']);

    // KOMISIA — hodnotenie Programu A
    Route::get('/komisia/prihlasky', [PrihlaskaController::class, 'komisiaPrihlasky']);
    Route::patch('/komisia/prihlasky/{prihlaska}', [PrihlaskaController::class, 'komisiaHodnotit']);
});