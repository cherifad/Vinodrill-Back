<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return response()->json([
            'success' => true,
            'data' => $client
        ]); 
    }

    public static function findById(int $id)
    {
        $client = Client::where('idclient', $id)->first();

        $client->adresses;

        $client->commandes->each(function($commande) {
            $commande->paiement;
            $commande->reservations;
        });

        $client->paiements->each(function($paiement) {
            $paiement->paiements;
        });

        return $client;
    }

    public function updateWithId(int $id, Request $request)
    {
        // validate the request
        $this->validate($request, [
            'nomclient' => ['required', 'string', 'max:255'], 
            'prenomclient' => ['required', 'string', 'max:255'],
            'datenaissance' => ['required', 'date', "before:" . date('d-m-Y', strtotime('18 years ago')) . ""],
            'sexe' => ['required', 'string', 'max:1'],
            'emailclient' => ['required', 'string', 'email', 'max:255'],
        ]);

        $client = Client::where('idclient', $id)->first();

        $client->update($request->all());

        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // validate the request
        $this->validate($request, [
            'idclient' => 'required',
            'nomclient' => ['required', 'string', 'max:255'], 
            'prenomclient' => ['required', 'string', 'max:255'],
            'datenaissance' => ['required', 'date', "before:" . date('d-m-Y', strtotime('18 years ago')) . ""],
            'sexe' => ['required', 'string', 'max:1'],
            'emailclient' => ['required', 'string', 'email', 'max:255'],
        ]);

        // update the existing client
        $client = Client::where('idclient', $request->idclient)->first();
        $client->update($request->all());

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
