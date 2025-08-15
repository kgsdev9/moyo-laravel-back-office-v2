<?php

namespace App\Http\Controllers\Commande;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCommandesByArg($id, Request $request)
    {

        $arg = $request->query('arg', 0); // valeur par défaut = 0

        $commandes = Commande::when($arg == 1, function ($query) use ($id) {
            // Filtrer uniquement les commandes de l'utilisateur
            return $query->where('user_id', $id);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $commandes
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function versementCommande(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'user_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
        ]);

        $commande = Commande::findOrFail($request->commande_id);
        $soldeUser = Solde::where('user_id', $request->user_id)->firstOrFail();

        $montantRestant = $commande->montantttc - $commande->montantregle;

        if ($request->montant > $montantRestant) {
            return response()->json([
                'success' => false,
                'message' => 'Le montant ne peut pas dépasser le reste à payer.'
            ], 400);
        }

        if ($request->montant > $soldeUser->solde) {
            return response()->json([
                'success' => false,
                'message' => 'Le montant ne peut pas dépasser votre solde.'
            ], 400);
        }

        DB::transaction(function () use ($commande, $soldeUser, $request) {
            $commande->montantregle += $request->montant;
            $commande->montantrestant = $commande->montantttc - $commande->montantregle;
            $commande->save();

            $soldeUser->solde -= $request->montant;
            $soldeUser->save();
        });

        Transaction::create([
            'user_id'          => $request->user_id,
            'name'             => "Versement commande {$commande->id}",
            'reference'        => uniqid('REF-'),
            'montant'          => $request->montant,
            'typeoperation'    => 'fourniture',
            'commande_id'  => $commande->id,
            'status'           => 'succes',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Versement enregistré avec succès',
            'data' => [
                'montantregle' => $commande->montantregle,
                'montantrestant' => $commande->montantrestant,
                'solde' => $soldeUser->solde
            ]
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
