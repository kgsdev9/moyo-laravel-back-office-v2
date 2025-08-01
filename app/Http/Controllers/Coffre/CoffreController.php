<?php

namespace App\Http\Controllers\Coffre;

use App\Http\Controllers\Controller;
use App\Models\Coffre;
use Illuminate\Http\Request;

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
        $request->validate([
            'user_id' => 'required|exists:coffres,user_id',
            'type' => 'required|in:credit,debit',
            'montant' => 'required|numeric|min:0.01',
        ]);

        $coffre = Coffre::where('user_id', $request->user_id)->first();

        if (!$coffre) {
            return response()->json(['message' => 'Coffre non trouvé'], 404);
        }

        if ($request->type === 'debit') {
            if ($coffre->solde < $request->montant) {
                return response()->json(['message' => 'Fonds insuffisants'], 400);
            }
            $coffre->solde -= $request->montant;
        } else {
            $coffre->solde += $request->montant;
        }

        $coffre->save();

        return response()->json([
            'message' => 'Opération réussie',
            'solde' => $coffre->solde,
        ]);
    }
}
