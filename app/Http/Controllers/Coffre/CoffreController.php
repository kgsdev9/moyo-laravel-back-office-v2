<?php

namespace App\Http\Controllers\Coffre;

use App\Http\Controllers\Controller;
use App\Models\Coffre;
use App\Models\Solde;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class CoffreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSoldeByUserId($user_id)
    {
        $coffre = Coffre::where('user_id', $user_id)->first();

        if (!$coffre) {
            return response()->json(['message' => 'Coffre non trouvé'], 404);
        }
        return response()->json([
            'user_id' => $user_id,
            'solde' => $coffre->solde ?? 0,
        ]);
    }




    /**
     * Créditer ou débiter le solde du coffre
     */


    public function creditOrDebit(Request $request)
    {
        $userId = $request->user_id;
        $montant = $request->montant;
        $type = $request->type;

        $user = User::find($userId);
        $coffre = Coffre::where('user_id', $userId)->first();
        $solde = Solde::where('user_id', $userId)->first();

        if (!$user || !$coffre || !$solde) {
            return response()->json(['message' => 'Coffre, Solde ou Utilisateur introuvable'], 404);
        }

        if ($type == 'debit') {
            // Transfert du coffre vers le solde
            if ($coffre->solde < $montant) {
                return response()->json(['message' => 'Fonds insuffisants dans le coffre'], 400);
            }

            $coffre->solde -= $montant;
            $solde->solde += $montant;

            // 💾 Enregistrement de la transaction
            Transaction::create([
                'user_id'        => $userId,
                'name'           => "Transfert de {$montant} FCFA du coffre vers le solde",
                'reference'      => uniqid('REF-'),
                'montant'        => -$montant,
                'typeoperation'  => 'transfert',
                'status'           => 'succes',
            ]);
        } elseif ($type == 'credit') {
            // Transfert du solde vers le coffre
            if ($solde->solde < $montant) {
                return response()->json(['message' => 'Fonds insuffisants sur le compte'], 400);
            }

            $solde->solde -= $montant;
            $coffre->solde += $montant;

            // 💾 Enregistrement de la transaction
            Transaction::create([
                'user_id'        => $userId,
                'name'           => "Recharge du coffre depuis le solde principal ({$montant} FCFA)",
                'reference'      => uniqid('REF-'),
                'montant'        => +$montant,
                'typeoperation'  => 'transfert',
                'status'           => 'succes',
            ]);
        }

        $coffre->save();
        $solde->save();

        return response()->json([
            'message'          => 'Opération réussie',
            'coffre_solde'     => $coffre->solde,
            'solde_principal'  => $solde->solde,
        ]);
    }
}
