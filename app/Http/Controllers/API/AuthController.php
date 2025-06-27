<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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

    public function loginWithPin(Request $request)
    {
       

        $request->validate([
            'phone' => 'required|string',
            'pin'   => 'required|digits:6',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (! $user || ! \Hash::check($request->pin, $user->pin)) {
            return response()->json(['message' => 'Erreurs sur les informations de connexions'], 401);
        }

        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
            'phone' => $request->phone
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
