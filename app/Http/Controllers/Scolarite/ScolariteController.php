<?php

namespace App\Http\Controllers\Scolarite;

use App\Http\Controllers\Controller;
use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ScolariteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function payer(Request $request)
    {

        // Étape 2 : Vérification du solde utilisateur
        $solde = Solde::where('user_id', $request->user_id)->first();

        if (!$solde || $solde->solde < $request->montant) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Solde insuffisantFF.',
                'solde'  => $solde->solde
            ], 400);
        }

        // Étape 3 : Décrémenter le solde
        $solde->solde -= $request->montant;
        $solde->save();

        // Étape 4 : Enregistrer la transaction
        $transaction = Transaction::create([
            'name'           => 'Paiement de scolarite',
            'user_id'        => $request->user_id,
            'reference'      => rand(100000, 999999),
            'montant'        => $request->montant,
            'typeoperation'  => 'retrait',
            'status'         => 'succes',
        ]);

        return response()->json([
            'status'      => 'success',
            'transaction' => $transaction,
            'new_solde'   => $solde->montant,
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
