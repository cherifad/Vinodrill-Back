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
use App\Http\Controllers\API\ActiviteController;
use App\Http\Controllers\API\SocieteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use Symfony\Component\Filesystem\Filesystem;
use App\Http\Controllers\API\CommandeController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\MultipleUploadController;
use App\Http\Controllers\API\CouponController;
use Twilio\Rest\Client;

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

// User
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return ClientController::findById($request->user()->id);
});

Route::apiResource('user', ClientController::class)
    ->only(['update'])
    ->middleware('auth:sanctum');

Route::apiResource('adresse', AdresseController::class)
    ->only(['store', 'update', 'destroy', 'show'])
    ->middleware('auth:sanctum');


// Public
Route::apiResource('sejour', SejourController::class);
Route::apiResource('avis', AviController::class);
Route::post('/avis/reponse', [AviController::class, 'storeReponse']);
Route::apiResource('destination', DestinationController::class);
Route::apiResource('theme', ThemeController::class);
Route::apiResource('catparticipant', CatparticipantController::class);
Route::apiResource('participe', ParticipeController::class);
Route::apiResource('hebergement', HebergementController::class);
Route::apiResource('partenaire', PartenaireController::class);
Route::apiResource('cave', CaveController::class);
Route::apiResource('visite', VisiteController::class);
Route::apiResource('typevisite', TypevisiteController::class);
Route::apiResource('activite', ActiviteController::class);
Route::apiResource('societe', SocieteController::class);
Route::apiResource('commande', CommandeController::class);
Route::apiResource('hotel', HotelController::class);

Route::post('/upload', function (Request $request) {    

    $validatedData = $request->validate([
        'file' => 'required|file|mimes:jpg,jpeg,png,svg|max:2048',
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $path = $file->store('uploads', 'public');
        $url = Storage::disk('public')->url($path);
        return response()->json(['success' => true, 'url' => $url]);
    } else {
        return response()->json(['error' => 'No file was uploaded']);
    }

    // $file = $request->fichier;
    // $path = $file->store('uploads', 'public');
    // $path = $file->storeAs('uploads', 'custom_filename.jpg', 'public');

    // return response()->json(['success' => true, 'path' => $path]);
});

Route::post('/multiple-upload', [MultipleUploadController::class, 'upload']);
Route::post('/coupon/check', [CouponController::class, 'check']);
Route::post('/coupon/get', [CouponController::class, 'get']);

Route::get('/login', function () {
    // Generate a random login code
    $loginCode = rand(10000, 99999);

    // Save the login code to the session
    session(['login_code' => $loginCode]);

    // Send the login code to the user via SMS
    $sid = env('TWILIO_ACCOUNT_SID');
    $token = env('TWILIO_SECRET');
    $from = "your_twilio_phone_number";
    $to = "the_user's_phone_number";

    $twilio = new Client($sid, $token);

    $message = $twilio->messages
                      ->create($to, // to
                               ['from' => $from, 'body' => $loginCode]
                      );

    // Redirect the user to the login code verification form
    return redirect('/verify-login-code');
});
