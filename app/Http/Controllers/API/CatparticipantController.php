<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Catparticipant;
use Illuminate\Http\Request;

class CatparticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all catparticipants
        $catparticipants = Catparticipant::all();

        // return catparticipants as a resource with success message
        return response()->json([
            'success' => true,
            'data' => $catparticipants
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
     * @param  \App\Models\Catparticipant  $catparticipant
     * @return \Illuminate\Http\Response
     */
    public function show(Catparticipant $catparticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catparticipant  $catparticipant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catparticipant $catparticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catparticipant  $catparticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catparticipant $catparticipant)
    {
        //
    }
}
