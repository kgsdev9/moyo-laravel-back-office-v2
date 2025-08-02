<?php

namespace App\Http\Controllers\Cagnote;

use App\Http\Controllers\Controller;
use App\Models\Cagnote;
use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $cagnotte = Cagnote::create([
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
    public function show(int $id)
    {
        $cagnote = Cagnote::with('user')->find($id);

        if (!$cagnote) {
            return response()->json(['message' => 'Cagnotte introuvable'], 404);
        }

        // Calcul du pourcentage
        $objectif = $cagnote->montant_objectif;
        $collecte = $cagnote->montant_collecte;
        $pourcentage = $objectif > 0 ? round(($collecte / $objectif) * 100, 2) : 0;

        return response()->json([
            'cagnote' => [
                'id' => $cagnote->id,
                'nom' => $cagnote->nom,
                'description' => $cagnote->description,
                'montant_objectif' => $objectif,
                'montant_collecte' => $collecte,
                'pourcentage' => $pourcentage,
                'user_nomcomplet' => $cagnote->user->nomcomplet ?? null,
                'date_limite' => $cagnote->date_limite,
                'status' => $cagnote->status,
            ],
        ]);
    }


    public function participer(Request $request)
    {
        $cagnotte = Cagnote::findOrFail($request->cagnotte_id);
        $solde = Solde::where('user_id', $request->user_id)->first();

        if (!$solde || $solde->solde < $request->montant) {
            return response()->json(['message' => 'Solde insuffisant.'], 400);
        }
        // Début transaction DB pour sécurité
        DB::beginTransaction();

        try {
            // Retirer le montant du solde utilisateur
            $solde->solde -= $request->montant;
            $solde->save();

            // Augmenter le montant_collecte de la cagnotte
            $cagnotte->montant_collecte += $request->montant;
            $cagnotte->save();

            Transaction::create([
                'user_id'       => $request->user_id,
                'name'          => "Participation à la cagnotte ({$request->montant} FCFA)",
                'reference'     => strtoupper(Str::random(10)), // ou uniqid('REF-')
                'montant'       => +$request->montant,
                'typeoperation' => 'cagnote',
                'status'        => 'succes',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Participation enregistrée avec succès.',
                'nouveau_solde' => $solde->solde,
                'montant_collecte' => $cagnotte->montant_collecte,
                'pourcentage' => $cagnotte->pourcentage,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la participation.'], 500);
        }
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
