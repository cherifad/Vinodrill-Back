<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Participe;
use Illuminate\Http\Request;

class ParticipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all participes
        $participes = Participe::all();

        // return participes as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $participes
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
     * @param  \App\Models\Participe  $participe
     * @return \Illuminate\Http\Response
     */
    public function show(Participe $participe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Participe  $participe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participe $participe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Participe  $participe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participe $participe)
    {
        //
    }
}
