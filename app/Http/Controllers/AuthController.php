<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected AuthService $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|exists:users,telephone',
            'password' => 'required|string|min:4',
        ]);

        $user = User::where('telephone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        // Ici on stocke le codeSecret (mot de passe) hashé pour sécurité
        $user->codeSecret = Hash::make($request->password);
        $user->password = Hash::make($request->password);
        $user->save();

        // Si tu utilises token JWT ou Sanctum, crée un token et renvoie-le
        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'message' => 'Mot de passe mis à jour avec succès',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function sendCode(Request $request)
    {
        $request->validate(['phone' => 'required|string']);
        $phone = $request->input('phone');

        $user = User::where('telephone', $phone)->first();
        if ($user) {
            if ($user->codeSecret == '' || $user->codeSecret == null) {
                return response()->json([
                    'user' => [
                        'id' => $user->id,
                        'phone' => $user->telephone,
                        'role' => $user->role,
                        'newscodeadefinir' => 1
                    ]
                ]);
            } else {
                return response()->json([
                    'user' => [
                        'id' => $user->id,
                        'phone' => $user->telephone,
                        'role' => $user->role,
                        'newscodeadefinir' => 0
                    ]
                ]);
            }
        }


        $data = $this->auth->sendVerificationCode($phone);

        return response()->json([
            'message' => 'Code envoyé par e-mail',
            'code'    => $data['code'],
        ]);
    }

    public function createOrUpdateProfilUser(Request $request)
    {
        // On récupère l'utilisateur via le numéro de téléphone ou on le crée
        $user = User::firstOrNew(['telephone' => $request->phone]);

        // On met à jour les champs
        $user->nomcomplet = $request->input('nomcomplet');
        $user->adresse = $request->input('adresse');
        $user->commune_id = $request->input('commune');
        $user->assignPublicKey();

        // Upload des fichiers
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
        $token = $user->createToken('mobile_token')->plainTextToken;


        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function sendCodeByResetPassword(Request $request)
    {
        $phone = $request->input('phone');

        $user = User::where('telephone', $phone)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Numero inconnu dans nos bases'
            ]);
        }

        $data = $this->auth->sendVerificationCode($phone);

        return response()->json([
            'message' => 'Code envoyé par e-mail',
            'code'    => $data['code'],
        ]);
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code'  => 'required|string',
        ]);

        $user = $this->auth->verifyCode($request->phone, $request->code);

        if (!$user) {
            return response()->json(['error' => 'Code invalide ou expiré'], 401);
        }

        return response()->json([
            'user'   => $user,
            'coffre' => $user->coffre,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'pin'   => 'required|string',
        ]);

        $user = $this->auth->login($request->phone, $request->pin);

        if (!$user) {
            return response()->json(['message' => 'Erreurs sur les informations de connexion'], 401);
        }

        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }
    public function verifyPassword(Request $request)
    {

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur introuvable'], 404);
        }

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['valid' => true], 200);
        }

        return response()->json(['valid' => false], 401);
    }

    public function updatePin(Request $request)
    {
        $user = User::find($request->user_id);
        $user->codeSecret = Hash::make($request->pin);
        $user->save();

        return response()->json(['message' => 'PIN mis à jour avec succès']);
    }


    public function setSecret(Request $request)
    {
        $request->validate([
            'userId' => 'required|integer',
            'pin'    => 'required|string',
        ]);

        try {
            $user = $this->auth->setSecret($request->userId, $request->pin, $request->nomComplet);
            if (!$user) return response()->json(['error' => 'Utilisateur non trouvé'], 404);

            $token = $user->createToken('mobile_token')->plainTextToken;

            return response()->json([
                'message' => 'Profil enregistré avec succès.',
                'user'    => $user,
                'token'   => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erreur serveur',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
