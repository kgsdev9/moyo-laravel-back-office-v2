<?php

namespace App\Services;

use App\Models\Solde;
use App\Models\User;

class SoldeService
{
    public function getSoldeByUserId($userId): ?array
    {
        $user = User::find($userId);

        if (!$user) {
            return null;
        }

        $solde = Solde::where('user_id', $userId)->first();

        return [
            'user_id' => $user->id,
            'solde' => $solde ? $solde->solde : 0,
        ];
    }
}
