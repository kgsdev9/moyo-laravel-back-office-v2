<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'pin'         => bcrypt($request->pin),
            'codemembre'  => User::generateCodeMembre(),
            'qrcode'      => User::generateQrCode(),
        ]);

        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function sendCode(Request $request)
    {
        $request->validate(['phone' => 'required|string']);
        $phone = $request->input('phone');

        $user = User::where('telephone', $phone)->first();
        if ($user) {
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'phone' => $user->telephone,
                    'role' => $user->role,
                ]
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

    public function setSecret(Request $request)
    {
        $request->validate([
            'userId' => 'required|integer',
            'pin'    => 'required|string',
        ]);

        try {
            $user = $this->auth->setSecret($request->userId, $request->pin);
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
