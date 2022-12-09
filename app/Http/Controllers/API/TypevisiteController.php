<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Typevisite;
use Illuminate\Http\Request;

class TypevisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typevisites = Typevisite::all();

        return response()->json([
            'sucess' => true,
            'data' => $typevisites
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
     * @param  \App\Models\Typevisite  $typevisite
     * @return \Illuminate\Http\Response
     */
    public function show(Typevisite $typevisite)
    {
        return response()->json([
            'success' => true,
            'data' => $typevisite
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Typevisite  $typevisite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Typevisite $typevisite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Typevisite  $typevisite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Typevisite $typevisite)
    {
        //
    }
}
