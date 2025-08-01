<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UpdateProfilCompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function updateOrCreateProfil(Request $request)
    {
        // Cherche un profil existant pour ce user_id
        $user = User::where('id', $request->user_id)->first();

        // Remplissage des champs textes
        $user->nomcomplet = $request->fullname;
        $user->adresse = $request->adresse ?? null;
        $user->statusCompte = 1;

        return response()->json([
            'message' => $user->wasRecentlyCreated ? 'Profil créé avec succès.' : 'Profil mis à jour.',
            'statusacompte' => 1
        ]);
    }

}
