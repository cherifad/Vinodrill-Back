<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hebergement;
use App\Models\Hotel;
use App\Models\Partenaire;
use Illuminate\Http\Request;

class HebergementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all hebergements
        $hebergements = Hebergement::all();

        //get parameters from request
        $idetape = request('etape');
        $hotel = request('hotel');

        //filter hebergements
        if ($idetape) {
            // we can have multiple etapes
            $idetapes = explode(',', $idetape);
            $hebergements = $hebergements->whereIn('idhebergement', $idetapes);
        }

        if ($hotel) {
            $hebergements = $hebergements->where('idpartenaire', $hotel);
        }

        // return hebergements with success status
        return response()->json([
            'success' => true,
            'data' => $hebergements
        ]);
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
            'nompartenaire' => 'required',
            'ruepartenaire' => 'required',
            'cppartenaire' => 'required',
            'villepartenaire' => 'required',
            'photopartenaire' => 'required',
            'emailparenaire' => 'required',
            'contact' => 'required',
            'detailpartenaire' => 'required',
            'libellehebergement' => 'required',
            'descriptionhebergement' => 'required',
            'nbchambre' => 'required',
            'horairehebergement' => 'required',
            'nbetoilehotel' => 'required',
        ]);

        // create new partenaire
        // $partenaire = new Partenaire();
        // $partenaire->nompartenaire = $request->nompartenaire;
        // $partenaire->ruepartenaire = $request->ruepartenaire;
        // $partenaire->cppartenaire = $request->cppartenaire;
        // $partenaire->villepartenaire = $request->villepartenaire;
        // $partenaire->photopartenaire = $request->photopartenaire;
        // $partenaire->emailpartenaire = $request->emailpartenaire;
        // $partenaire->contact = $request->contact;
        // $partenaire->detailpartenaire = $request->detailpartenaire;
        // $partenaire->save();

        // create partenaire using Partenaire::create
        $partenaire = Partenaire::create([
            'nompartenaire' => $request->nompartenaire,
            'ruepartenaire' => $request->ruepartenaire,
            'cppartenaire' => $request->cppartenaire,
            'villepartenaire' => $request->villepartenaire,
            'photopartenaire' => $request->photopartenaire,
            'emailpartenaire' => $request->emailpartenaire,
            'contact' => $request->contact,
            'detailpartenaire' => $request->detailpartenaire,
        ]);

        $partenaire = Partenaire::orderBy('idpartenaire', 'desc')->first();

        // create new hotel
        $hotel = new Hotel();
        $hotel->idpartenaire = $partenaire->idpartenaire;
        $hotel->nompartenaire = $request->nompartenaire;
        $hotel->ruepartenaire = $request->ruepartenaire;
        $hotel->cppartenaire = $request->cppartenaire;
        $hotel->villepartenaire = $request->villepartenaire;
        $hotel->photopartenaire = $request->photopartenaire;
        $hotel->emailpartenaire = $request->emailpartenaire;
        $hotel->contact = $request->contact;
        $hotel->detailpartenaire = $request->detailpartenaire;
        $hotel->nbetoilehotel = $request->nbetoilehotel;
        $hotel->save();

        // create new hebergement
        $hebergement = new Hebergement();
        $hebergement->libellehebergement = $request->libellehebergement;
        $hebergement->descriptionhebergement = $request->descriptionhebergement;
        $hebergement->nbchambre = $request->nbchambre;
        $hebergement->horairehebergement = $request->horairehebergement;
        $hebergement->idpartenaire = $partenaire->idpartenaire;
        $hebergement->save();

        // return hebergement with success status
        return response()->json([
            'success' => true,
            'data' => $hebergement
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hebergement  $hebergement
     * @return \Illuminate\Http\Response
     */
    public function show(Hebergement $hebergement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hebergement  $hebergement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hebergement $hebergement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hebergement  $hebergement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hebergement $hebergement)
    {
        //
    }
}
