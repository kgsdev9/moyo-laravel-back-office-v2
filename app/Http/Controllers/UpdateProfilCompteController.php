<?php

namespace App\Http\Controllers;

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
    public function verifyDocuments(Request $request)
    {
        $user = User::find($request->userId);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        if ($request->hasFile('piece_avant') && $request->file('piece_avant')->isValid()) {
            $file = $request->file('piece_avant');
            $filename = md5_file($file->getRealPath() . microtime()) . '.' . $file->extension();
            $path = $file->storeAs('pieces', $filename);
            $user->piece_recto = $path;
        }

        if ($request->hasFile('piece_arriere') && $request->file('piece_arriere')->isValid()) {
            $file = $request->file('piece_arriere');
            $filename = md5_file($file->getRealPath() . microtime()) . '.' . $file->extension();
            $path = $file->storeAs('pieces', $filename);
            $user->piece_verso = $path;
        }

        $user->save();

        return response()->json(['message' => 'Documents soumis avec succès']);
    }
}
