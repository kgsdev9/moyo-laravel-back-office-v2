<?php

namespace App\Http\Controllers\Scolarite;

use App\Http\Controllers\Controller;
use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ScolariteController extends Controller
{
    private function generateUniqueReference()
    {
        do {
            $prefix = 'SCOL-' . now()->format('Ymd') . '-';
            $random = strtoupper(Str::random(8)); // ex: AB12CD34
            $reference = $prefix . $random;
        } while (Transaction::where('reference', $reference)->exists());

        return $reference;
    }

    public function payer(Request $request)
    {

        $userId = $request->user_id;
        $montant = $request->montant;

        // Vérifier le solde
        $solde = Solde::where('user_id', $userId)->lockForUpdate()->first(); // Verrouillage optimiste
        if (!$solde || $solde->solde < $montant) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Solde insuffisant.',
                'solde'   => $solde ? $solde->solde : 0
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Décrémente le solde
            $solde->solde -= $montant;
            $solde->save();

            // Générer une référence unique
            $reference = $this->generateUniqueReference();

            // Enregistrement de la transaction
            $transaction = Transaction::create([
                'name'           => 'Paiement de scolarite',
                'user_id'        => $userId,
                'reference'      =>$reference,
                'montant'        =>-$montant,
                'typeoperation'  => 'scolarite',
                'ecole_id' =>   $request->school_id,
                'status'         => 'succes',
            ]);

            DB::commit();

            return response()->json([
                'status'      => 'success',
                'transaction' => $transaction,
                'new_solde'   => $solde->solde,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Une erreur est survenue lors du paiement.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


}
