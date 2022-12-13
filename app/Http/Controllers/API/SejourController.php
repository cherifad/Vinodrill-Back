<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Participe;
use App\Models\FaitPartiDe;
use App\Models\Sejour;
use Illuminate\Http\Request;

class SejourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all sejours
        $sejours = Sejour::all();

        //get parameters from request
        $iddestination = request('destination');
        $idtheme = request('theme');
        $titresejour = request('titre');
        $etape = request('etape');
        $participe = request('participe');
        $exceptId = request('except'); //except idsejour, used for related
        $idsej = request('idsejour'); //

        // limit number of sejours
        $limit = request('limit');

        //filter sejours
        if ($iddestination && $iddestination != 'null') {
            // we can have multiple destinations
            $iddestinations = explode(',', $iddestination);
            $sejours = $sejours->whereIn('iddestination', $iddestinations);
        }

        if ($idsej) {
            $idssej = explode(',', $idsej);
            $sejours = $sejours->whereIn('idsejour', $idssej);
        }

        if ($idtheme && $idtheme != 'null') {
            // we can have multiple themes
            $idthemes = explode(',', $idtheme);
            $sejours = $sejours->whereIn('idtheme', $idthemes);
        }

        if ($etape) {
            $sejours = $sejours->where('etape', $etape);
        }

        if ($participe && $participe != 'null') {
            // we can have multiple participes
            $participes = explode(',', $participe);

            // we need to filter sejours with participes
            $catparticipants = Participe::whereIn('idcategorieparticipant', $participes);

            $idsejours = $catparticipants->pluck('idsejour')->toArray();

            $sejours = $sejours->whereIn('idsejour', $idsejours);
        }

        if ($exceptId) {
            $sejours = $sejours->where('idsejour', '!=', $exceptId);
        }

        if ($limit) {
            $sejours = $sejours->take($limit);
        }

        // return sejours as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $sejours
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
            'iddestination' => 'required',
            'idtheme' => 'required',
            'titresejour' => 'required',
            'photosejour' => 'required',
            'prixsejour' => 'required',
            'descriptionsejour' => 'required',
            'nbjour' => 'required',
            'nbnuit' => 'required'
        ]);

        // create new sejour
        $sejour = Sejour::create([
            'iddestination' => $request->iddestination,
            'idtheme' => $request->idtheme,
            'titresejour' => $request->titresejour,
            'photosejour' => $request->photosejour,
            'prixsejour' => $request->prixsejour,
            'descriptionsejour' => $request->descriptionsejour,
            'nbjour' => $request->nbjour,
            'nbnuit' => $request->nbnuit
        ]);

        // return sejour as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $sejour
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sejour  $sejour
     * @return \Illuminate\Http\Response
     */
    public function show(Sejour $sejour)
    {
        $avis = request('avis');
        $destination = request('destination');
        $theme = request('theme');
        $etape = request('etape');
        $catparticipant = request('catparticipant');
        $hebergement = request('hebergement');
        $visite = request('visite');

        if ($avis) {
            $sejour->avis;
        }

        if ($destination) {
            $sejour->destination;
        }

        if ($theme) {
            $sejour->theme;
        }

        if ($etape) {
            $sejour->etapes;
        }

        if ($catparticipant) {
            $sejour->catparticipant;
        }

        if ($hebergement) {
            $etapes = $sejour->etapes;
            $hebergements = [];

            foreach ($etapes as $etape) {
                $hebergements[] = $etape->hebergement->hotel;
            }
        }

        if ($visite) {
            $etapes = $sejour->etapes;
            $visites = [];


            foreach ($etapes as $etape) {
                dump($etape->fait_parti_des);
                $etape->fait_parti_des;
            }
        }

        if ($avis) {
            $sejour->avis;
            return response()->json([
                'success' => true,
                'data' => $sejour
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $sejour
            ]);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sejour  $sejour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sejour $sejour)
    {
        // validate request
        $this->validate($request, [
            'iddestination' => 'required',
            'idtheme' => 'required',
            'titresejour' => 'required',
            'photosejour' => 'required',
            'prixsejour' => 'required',
            'descriptionsejour' => 'required',
            'nbjour' => 'required',
            'nbnuit' => 'required'
        ]);

        // update sejour
        $sejour->update([
            'iddestination' => $request->iddestination,
            'idtheme' => $request->idtheme,
            'titresejour' => $request->titresejour,
            'photosejour' => $request->photosejour,
            'prixsejour' => $request->prixsejour,
            'descriptionsejour' => $request->descriptionsejour,
            'nbjour' => $request->nbjour,
            'nbnuit' => $request->nbnuit
        ]);

        // return sejour as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $sejour
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sejour  $sejour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sejour $sejour)
    {
        // delete sejour
        $sejour->delete();

        // return sejour as a resource with success message
        return response()->json();
    }
}

