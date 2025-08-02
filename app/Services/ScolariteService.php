<?php

namespace App\Services;

use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScolariteService
{
    public function payerScolarite(array $data): array
    {
        $userId = $data['user_id'];
        $montant = $data['montant'];
        $schoolId = $data['school_id'];

        $solde = Solde::where('user_id', $userId)->lockForUpdate()->first();
        if (!$solde || $solde->solde < $montant) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Solde insuffisant.',
                'solde' => $solde ? $solde->solde : 0,
            ];
        }

        try {
            DB::beginTransaction();

            $solde->solde -= $montant;
            $solde->save();

            $reference = $this->generateUniqueReference();

            $transaction = Transaction::create([
                'name'          => 'Paiement de scolarite',
                'user_id'       => $userId,
                'reference'     => $reference,
                'montant'       => -$montant,
                'typeoperation' => 'scolarite',
                'ecole_id'      => $schoolId,
                'status'        => 'succes',
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'code' => 201,
                'transaction' => $transaction,
                'new_solde' => $solde->solde,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Une erreur est survenue lors du paiement.',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function generateUniqueReference(): string
    {
        do {
            $prefix = 'SCOL-' . now()->format('Ymd') . '-';
            $random = strtoupper(Str::random(8));
            $reference = $prefix . $random;
        } while (Transaction::where('reference', $reference)->exists());

        return $reference;
    }
}
