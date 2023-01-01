<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Commande::all();

        $commandes = Commande::all();

        return response()->json([
            'success' => true,
            'data' => $commandes
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        $paiement = request('paiement');
        $client = request('client');
        $sejour = request('sejour');
        $reservation = request('reservation');
        $boncommande = request('boncommande');

        $full = request('full');

        if($paiement) {
            $commande->paiement;
        }

        if($client) {
            $commande->client;
        }

        if($sejour) {
            $reservations = $commande->reservations;

            foreach($reservations as $reservation) {
                $reservation->sejour;
            }
        }

        if($reservation) {
            $commande->reservations;
        }

        if($boncommande) {
            $commande->boncommandes;
        }

        if($full) {
            $commande->paiement;
            $commande->client;
            $reservations = $commande->reservations;

            foreach($reservations as $reservation) {
                $reservation->sejour;
            }
            
            $commande->boncommandes;
        }

        return response()->json([
            'success' => true,
            'data' => $commande
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
