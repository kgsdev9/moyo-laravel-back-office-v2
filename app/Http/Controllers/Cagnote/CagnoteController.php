<?php

namespace App\Http\Controllers\Cagnote;

use App\Http\Controllers\Controller;
use App\Models\Cagnote;
use App\Models\CagnoteSouscriveur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CagnoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cagnotes = Cagnote::with('user')->get();
        return response()->json([
            'cagnotes' => $cagnotes,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cagnotte = CagnoteSouscriveur::create([
            'code' => strtoupper(Str::random(10)),
            'nom' => $request->nom ?? 'test',
            'description' => $request->description ?? 'test',
            'montant_objectif' => $request->montant_objectif ?? 'tesdd',
            'montant_collecte' => 0,
            'date_limite' => $request->date_limite ?? now()->addWeeks(2),
            'status' => 'encours',
            'user_id' => 1,
        ]);

        return response()->json([
            'message' => 'Cagnotte créée avec succès.',
            'cagnotte' => $cagnotte,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

