<?php

namespace App\Services;

use App\Models\Solde;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionService
{
    public function getByPhone(string $phone): JsonResponse
    {
        if (empty($phone)) {
            return response()->json([
                'error' => 'Le numéro de téléphone est requis.'
            ], 400);
        }

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur introuvable.'
            ], 404);
        }

        $transactions = Transaction::where('user_id', $user->id)
            ->where('typeoperation', '!=', 'transfert')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function getTransactionByUser(string $id, int $arg): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur introuvable.'
            ], 404);
        }

        $query = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($arg === 1)
        {
            $query->where('typeoperation', '!=', 'transfert')->limit(6);
        }

        if($arg == 2)
        {
            $query->where('typeoperation', '!=', 'transfert')->limit(200);
        }

         if($arg == 3)
        {
            $query->where('typeoperation', 'like', 'transfert')->limit(200);
        }

        $transactions = $query->get();

        return response()->json($transactions);
    }


    public function createTransaction(array $data)
    {
        $user = User::where('telephone', $data['phone'])->firstOrFail();
        $typeoperation = 'depot';
        return DB::transaction(function () use ($data, $user, $typeoperation) {
            $transaction = Transaction::create([
                'user_id'          => $user->id,
                'name'             => "Recharge Compte",
                'reference'        => uniqid('REF-'),
                'montant'          => $data['amount'],
                'typeoperation'    => $typeoperation,
                'modereglement_id' => $data['mode_reglement_id'] ?? null,
                'status'           => 'succes',
            ]);

            // 2. Récupération ou création du solde de l'utilisateur
            $solde = Solde::firstOrCreate(
                ['user_id' => $user->id],
                ['solde' => 0]
            );


            // 3. Mise à jour du solde selon le type d'opération
            if ($typeoperation === 'depot') {
                $solde->solde = ($solde->solde ?? 0) + $data['amount'];
            } elseif ($typeoperation === 'retrait') {
                if (($solde->solde ?? 0) < $data['amount']) {
                    throw new \Exception('Solde insuffisant.');
                }
                $solde->solde -= $data['amount'];
            }

            // 4. Sauvegarde
            $solde->save();

            return $transaction;
        });
    }

    public function getTransactionById(int $id): Transaction
    {
        $transaction = Transaction::with(['ecole', 'user'])->find($id);
        if (!$transaction) {
            throw new ModelNotFoundException("Transaction introuvable.");
        }
        return $transaction;
    }
}
