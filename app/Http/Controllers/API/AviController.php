<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Avi;
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

        $titresejour = request("titresejour");
        $client = request("client");

        if($client){
            $avis = Avi::where('idclient', $client)->get();
        }

        if($titresejour){
            foreach($avis as $avi){
                // get only titre sejour for the sejour attached to the avis
                $avi->titresejour = $avi->sejour->titresejour;
            }
        }
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avi  $avi
     * @return \Illuminate\Http\Response
     */
    public function show(Avi $avi)
    {
        //
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
}
