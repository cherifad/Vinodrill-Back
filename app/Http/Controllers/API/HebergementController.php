<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hebergement;
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
        //
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
