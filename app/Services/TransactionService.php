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

        if ($arg === 1) {
            $query->where('typeoperation', '!=', 'transfert')->limit(6);
        }

        if ($arg == 2) {
            $query->where('typeoperation', '!=', 'transfert')->limit(200);
        }

        if ($arg == 3) {
            $query->where('typeoperation', 'like', 'transfert')->limit(200);
        }

        $transactions = $query->get();

        return response()->json($transactions);
    }

    public function createTransaction(array $data)
    {
        $user = User::where('id', $data['userId'])->firstOrFail();
        $typeoperation = 'depot';

        return DB::transaction(function () use ($data, $user, $typeoperation) {
            // Simuler appel API selon mode_reglement_id
            if ($data['mode_reglement_id'] == 1) {
                // Appel API Wave (simulation)
                $this->callWaveApi($data);
            } elseif ($data['mode_reglement_id'] == 2) {
                // Appel API Orange Money (simulation)
                $this->callOrangeMoneyApi($data);
            } elseif ($data['mode_reglement_id'] == 3) {
                // Appel API Mtn Money (simulation)
                $this->callOrangeMoovApi($data);
            }  elseif ($data['mode_reglement_id'] == 4) {
                // Appel API Moov Money (simulation)
                $this->callOrangeMoovApi($data);
            }

            else {
                throw new \Exception("Mode de règlement non supporté pour la simulation.");
            }

            $transaction = Transaction::create([
                'user_id'          => $user->id,
                'name'             => "Recharge Compte",
                'reference'        => uniqid('REF-'),
                'montant'          => $data['amount'],
                'typeoperation'    => $typeoperation,
                'modereglement_id' => $data['mode_reglement_id'] ?? null,
                'telephone' => $data['phone'],
                'status'           => 'succes',
            ]);

            $solde = Solde::firstOrCreate(
                ['user_id' => $user->id],
                ['solde' => 0]
            );

            if ($typeoperation === 'depot') {
                $solde->solde = ($solde->solde ?? 0) + $data['amount'];
            } elseif ($typeoperation === 'retrait') {
                if (($solde->solde ?? 0) < $data['amount']) {
                    throw new \Exception('Solde insuffisant.');
                }
                $solde->solde -= $data['amount'];
            }

            $solde->save();
            return $transaction;
        });
    }

    /**
     * Simule l'appel à l'API Wave
     */
    private function callWaveApi(array $data)
    {

        // Exemple : log pour simuler l'appel API
        \Log::info("Appel API Wave pour user {$data['userId']} avec montant {$data['amount']}");

        // Ici tu peux faire un vrai appel HTTP si besoin avec Guzzle ou autre
        // Par exemple:
        // $response = Http::post('https://api.wave.com/transaction', [...]);
        // vérifier $response->successful() etc.
    }

    /**
     * Simule l'appel à l'API Orange Money
     */
    private function callOrangeMoneyApi(array $data)
    {
        \Log::info("Appel API Orange Money pour user {$data['userId']} avec montant {$data['amount']}");

        // Similaire à Wave, tu peux ici appeler un service externe réel
    }

    private function callOrangeMtnApi(array $data)
    {
        \Log::info("Appel API Mtn Money pour user {$data['userId']} avec montant {$data['amount']}");

        // Similaire à Wave, tu peux ici appeler un service externe réel
    }

    private function callOrangeMoovApi(array $data)
    {
        \Log::info("Appel API Moov Money pour user {$data['userId']} avec montant {$data['amount']}");

        // Similaire à Wave, tu peux ici appeler un service externe réel
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
