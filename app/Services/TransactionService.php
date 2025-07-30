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
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function getTransactionByUser(string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur introuvable.'
            ], 404);
        }

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function createTransaction(array $data)
    {
        $user = User::where('telephone', $data['phone'])->firstOrFail();
        $typeoperation = 'depot';
        return DB::transaction(function () use ($data, $user, $typeoperation) {
            // 1. Création de la transaction
            $transaction = Transaction::create([
                'user_id'          => $user->id,
                'name'             => "Recharge Compte",
                'reference'        => uniqid('REF-'),
                'montant'          => $data['amount'],
                'typeoperation'    => $typeoperation,
                'modereglement_id' => $data['modereglement_id'] ?? null,
                'status'           => 'succes',
                'observation'      => 'observation',
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
        $transaction = Transaction::find($id);

        if (!$transaction) {
            throw new ModelNotFoundException("Transaction introuvable.");
        }
        return $transaction;
    }
}
