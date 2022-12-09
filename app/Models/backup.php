<?php

// register user controller 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomclient' => ['required', 'string', 'max:255'], 
            'prenomclient' => ['required', 'string', 'max:255'],
            'datenaissance' => ['required', 'date'],
            'sexe' => ['required', 'string', 'max:1'],
            'emailclient' => ['required', 'string', 'email', 'max:255', 'unique:'.Client::class],
            'motdepasse' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Client::create([
            'nomclient' => $request->nomclient,
            'prenomclient' => $request->prenomclient,
            'datenaissance' => $request->datenaissance,
            'sexe' => $request->sexe,
            'emailclient' => $request->emailclient,
            'motdepasse' => Hash::make($request->motdepasse),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}


// api route

use App\Http\Controllers\API\SejourController;
use App\Http\Controllers\API\AviController;
use App\Http\Controllers\API\DestinationController;
use App\Http\Controllers\API\CatparticipantController;
use App\Http\Controllers\API\ThemeController;
use App\Http\Controllers\API\ParticipeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('sejour', SejourController::class);
Route::apiResource('avis', AviController::class);
Route::apiResource('destination', DestinationController::class);
Route::apiResource('theme', ThemeController::class);
Route::apiResource('catparticipant', CatparticipantController::class);
Route::apiResource('participe', ParticipeController::class);