<?php

namespace App\Services;

use App\Models\Coffre;
use App\Models\Solde;
use App\Models\Transaction;
use App\Models\User;

class CoffreService
{
    public function getSoldeByUserId($user_id): ?array
    {
        $coffre = Coffre::where('user_id', $user_id)->first();

        if (!$coffre) {
            return null;
        }

        return [
            'user_id' => $user_id,
            'solde' => $coffre->solde ?? 0,
        ];
    }

    public function creditOrDebit(array $data): array
    {
        $userId = $data['user_id'];
        $montant = $data['montant'];
        $type = $data['type'];

        $user = User::find($userId);
        $coffre = Coffre::where('user_id', $userId)->first();
        $solde = Solde::where('user_id', $userId)->first();

        if (!$user || !$coffre || !$solde) {
            return [
                'status' => 'error',
                'code' => 404,
                'message' => 'Coffre, Solde ou Utilisateur introuvable'
            ];
        }

        if ($type === 'debit') {
            if ($coffre->solde < $montant) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Fonds insuffisants dans le coffre'
                ];
            }

            $coffre->solde -= $montant;
            $solde->solde += $montant;

            Transaction::create([
                'user_id' => $userId,
                'name' => "Transfert de {$montant} FCFA du coffre vers le solde",
                'reference' => uniqid('REF-'),
                'montant' => -$montant,
                'typeoperation' => 'transfert',
                'status' => 'succes',
            ]);
        } elseif ($type === 'credit') {
            if ($solde->solde < $montant) {
                return [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Fonds insuffisants sur le compte'
                ];
            }

            $solde->solde -= $montant;
            $coffre->solde += $montant;

            Transaction::create([
                'user_id' => $userId,
                'name' => "Recharge du coffre depuis le solde principal ({$montant} FCFA)",
                'reference' => uniqid('REF-'),
                'montant' => +$montant,
                'typeoperation' => 'transfert',
                'status' => 'succes',
            ]);
        }

        $coffre->save();
        $solde->save();

        return [
            'status' => 'success',
            'code' => 200,
            'message' => 'Opération réussie',
            'coffre_solde' => $coffre->solde,
            'solde_principal' => $solde->solde,
        ];
    }
}
