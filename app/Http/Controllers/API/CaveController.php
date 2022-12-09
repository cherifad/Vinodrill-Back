<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cave;
use Illuminate\Http\Request;

class CaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caves = Cave::all();

        return response()->json([
            'sucess' => true,
            'data' => $caves
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
     * @param  \App\Models\Cave  $cave
     * @return \Illuminate\Http\Response
     */
    public function show(Cave $cave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cave  $cave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cave $cave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cave  $cave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cave $cave)
    {
        //
    }
}
