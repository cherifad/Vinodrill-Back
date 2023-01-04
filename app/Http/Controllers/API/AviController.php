<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Avi;
use App\Models\ReponseAvi;
use App\Models\ImageAvis;
use Illuminate\Http\Request;

class AviController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all avis
        $avis = Avi::all();

        $idsejour = request("sejour");
        $client = request("client");

        if($client && $idsejour){
            $avis = Avi::where('idclient', $client)->where('idsejour', $idsejour)->get();
        }

        if($client && !$idsejour){
            $avis = Avi::where('idclient', $client)->get();
        }
        
        if($idsejour && !$client){
            $avis = Avi::where('idsejour', $idsejour)->get();
        }

        // do not return avis with estreponse is true
        $avis = $avis->filter(function ($value, $key) {
            return $value->estreponse == false;
        });

        // get all responses of each avis
        foreach($avis as $avi){
            // get responses of avis
            $idrep = $avi->reponse;

            if($idrep == null)
                continue;

            // get avis with idavis = idrep
            $reponse = Avi::where('idavis', $idrep->rep_idavis)->first();

            $avi->reponse_admin = $reponse;
        }

        // sort avis by idavis
        $avis = $avis->sortByDesc('idavis');

        // return avis as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $avis
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
        // validate data
        $this->validate($request, [
            'note' => 'required',
            'commentaire' => 'required',
            'titreavis' => 'required',
            'idsejour' => 'required',
            'idclient' => 'required',
        ]);

        // get current date
        $date = date('Y-m-d');
        
        // create avis
        $avi = Avi::create([
            'idsejour' => $request->idsejour,
            'idclient' => $request->idclient,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'titreavis' => $request->titreavis,
            'dateavis' => $date,
        ]);
        
        // foreach($request->img_ids as $img_id){
        //     $image_avis = ImageAvis::create([
        //         'idavis' => $avi->idavis,
        //         'idimage' => $img_id
        //     ]);
        // }
        // return avis as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $avi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avi  $avi
     * @return \Illuminate\Http\Response
     */
    public function show(Avi $avi)
    {
        // get responses of avis
        $idrep = $avi->reponse->rep_idavis;

        // get avis with idavis = idrep
        $reponse = Avi::where('idavis', $idrep)->first();

        $avi->reponse_admin = $reponse; 

        // return avis as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $avi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Avi  $avi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Avi $avi)
    {
        // update avis
        $this->validate($request, [
            'note' => 'required',
            'commentaire' => 'required',
            'titreavis' => 'required',
            'dateavis' => 'required',
            'avisignale' => 'required',
            'typesignalement' => 'required'            
        ]);

        $avi->update($request->all());

        // return avis as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $avi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avi  $avi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avi $avi)
    {
        //
    }

    public function storeReponse(Request $request)
    {
        // validate data
        $this->validate($request, [
            'idavis' => 'required',
            'commentaire' => 'required',
            'idclient' => 'required',
            'idsejour' => 'required',
        ]);

        
        try {
            $reponse = Avi::Create([
                'titreavis' => 'Reponse',
                'idsejour' => $request->idsejour,
                'idclient' => $request->idclient,
                'commentaire' => $request->commentaire,
                'note' => 0,
                'dateavis' => date('d-m-Y'),
                'estreponse' => true,
            ]);
    
            // get the highest id of avis table 
            $rep_id = Avi::max('idavis');
    
            // create avis
            $reponse = ReponseAvi::create([
                'rep_idavis' => $rep_id,
                'idavis' => $request->idavis,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }





        // return avis as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $reponse
        ]);
    }
}
