<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Adresse;
use Illuminate\Http\Request;

class AdresseController extends Controller
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
         // validate request
         $this->validate($request, [
            'libelle' => 'required',
            'rue' => 'required',
            'ville' => 'required',
            'codepostal' => 'required',
            'pays' => 'required',
            'idclient' => 'required',
        ]);

        $adresse = new Adresse();

        $adresse->libelleadresse = $request->libelle;
        $adresse->rueadresse = $request->rue;
        $adresse->villeadresse = $request->ville;
        $adresse->cpadresse = $request->codepostal;
        $adresse->pays = $request->pays;
        $adresse->idclient = $request->idclient;

        $adresse->save();

        return response()->json([
            'success' => true,
            'data' => $adresse->toArray()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function show(Adresse $adresse)
    {
        //
        return response()->json([
            'success' => true,
            'data' => $adresse
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adresse $adresse)
    {
        // validate request
        $this->validate($request, [
            'libelle' => 'required',
            'rue' => 'required',
            'ville' => 'required',
            'codepostal' => 'required',
            'pays' => 'required',
        ]);

        $adresse->libelleadresse = $request->libelle;
        $adresse->rueadresse = $request->rue;
        $adresse->villeadresse = $request->ville;
        $adresse->cpadresse = $request->codepostal;
        $adresse->pays = $request->pays;

        $adresse->save();

        return response()->json([
            'success' => true,
            'data' => $adresse
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adresse $adresse)
    {
        $adresse->delete();

        return response()->json([
            'success' => true,
            'message' => 'Adresse supprimée'
        ]);
    }
}
