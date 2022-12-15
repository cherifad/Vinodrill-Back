<?php

use App\Http\Controllers\API\SejourController;
use App\Http\Controllers\API\AviController;
use App\Http\Controllers\API\DestinationController;
use App\Http\Controllers\API\CatparticipantController;
use App\Http\Controllers\API\ThemeController;
use App\Http\Controllers\API\ParticipeController;
use App\Http\Controllers\API\HebergementController;
use App\Http\Controllers\API\PartenaireController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\AdresseController;
use App\Http\Controllers\API\CaveController;
use App\Http\Controllers\API\VisiteController;
use App\Http\Controllers\API\TypevisiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return ClientController::findById($request->user()->id);
});

Route::apiResource('user', ClientController::class)
    ->only(['update'])
    ->middleware('auth:sanctum');

// Route::get('/login/{provider}', [AuthController::class,'redirectToProvider']);
// Route::get('/login/{provider}/callback', [AuthController::class,'handleProviderCallback']);

Route::apiResource('adresse', AdresseController::class)
    ->only(['store', 'update', 'destroy', 'show'])
    ->middleware('auth:sanctum');


Route::apiResource('sejour', SejourController::class);
Route::apiResource('avis', AviController::class);
Route::apiResource('destination', DestinationController::class);
Route::apiResource('theme', ThemeController::class);
Route::apiResource('catparticipant', CatparticipantController::class);
Route::apiResource('participe', ParticipeController::class);
Route::apiResource('hebergement', HebergementController::class);
Route::apiResource('partenaire', PartenaireController::class);
Route::apiResource('cave', CaveController::class);
Route::apiResource('visite', VisiteController::class);
Route::apiResource('typevisite', TypevisiteController::class);

