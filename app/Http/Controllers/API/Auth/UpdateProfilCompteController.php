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
        // Cherche l'utilisateur existant ou en crée un nouveau sans le sauvegarder encore
        $user = User::firstOrNew(['id' => $request->user_id]);

        // Upload piece_recto si présent
        if ($request->hasFile('piece_recto') && $request->file('piece_recto')->isValid()) {
            $file = $request->file('piece_recto');
            $originalName = $file->getClientOriginalName();
            $user->piece_recto = $file->storeAs('pieces', $originalName);
        }

        // Upload piece_verso si présent
        if ($request->hasFile('piece_verso') && $request->file('piece_verso')->isValid()) {
            $file = $request->file('piece_verso');
            $originalName = $file->getClientOriginalName();
            $user->piece_verso = $file->storeAs('pieces', $originalName);
        }

        // Mise à jour des infos texte
        $user->nomcomplet = $request->fullname;
        $user->adresse = $request->adresse ?? null;
        $user->commune_id = $request->commune_id ?? null;
        $user->statusCompte = 1;

        // Sauvegarde
        $user->save();

        return response()->json([
            'message' => 'Profil mis à jour.',
            'statusacompte' => 1
        ]);
    }
}
