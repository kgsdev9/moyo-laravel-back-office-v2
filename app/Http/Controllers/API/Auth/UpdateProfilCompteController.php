<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profil;
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
        $profil = Profil::where('user_id', $request->user_id)->first();

        // Sinon on instancie un nouveau
        if (!$profil) {
            $profil = new Profil();
            $profil->user_id = $request->user_id;
        }

        // Remplissage des champs textes
        $profil->nomcomplet = $request->fullname;
        $profil->adresse = $request->adresse ?? null;
        $profil->status = 1;

        if ($request->hasFile('piece_recto')) {
            $profil->piece_recto = $request->file('piece_recto')->store('pieces', 'public');
        }

        if ($request->hasFile('piece_verso')) {
            $profil->piece_verso = $request->file('piece_verso')->store('pieces', 'public');
        }

        $profil->save();

        // Mise à jour du champ 'active' dans la table users pour ce user_id
        $user = User::find($request->user_id);
        if ($user) {
            $user->statusCompte = 1;
            $user->save();
        }

        return response()->json([
            'message' => $profil->wasRecentlyCreated ? 'Profil créé avec succès.' : 'Profil mis à jour.',
            'profil' => $profil,
            'statusacompte' => 1
        ]);
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
