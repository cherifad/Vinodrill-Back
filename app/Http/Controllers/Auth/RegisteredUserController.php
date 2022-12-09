<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $creation = request('creation');

        $request->validate([
            'nomclient' => ['required', 'string', 'max:255'], 
            'prenomclient' => ['required', 'string', 'max:255'],
            'datenaissance' => ['required', 'date', "before:" . date('d-m-Y', strtotime('18 years ago')) . ""],
            'sexe' => ['required', 'string', 'max:1'],
            'emailclient' => ['required', 'string', 'email', 'max:255', 'unique:'.Client::class],
            'motdepasse' => ['required', 'confirmed', Rules\Password::min(8)
                                                            ->mixedCase()
                                                            ->letters()
                                                            ->numbers()
                                                            ->symbols()
                                                            ->uncompromised(),],
        ]);

        if(true)
        {
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
        } else {
            return response()->json([
                'success' => true,
            ]);
        }

        

        // $user = User::create([
        //     'name' => $request->nomclient,
        //     'email' => $request->emailclient,
        //     'password' => Hash::make($request->motdepasse),
        // ]);

        
    }
}
