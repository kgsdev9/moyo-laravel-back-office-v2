<?php

namespace App\Services;

use App\Models\Cagnote;
use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CagnoteService
{
    public function getAll()
    {
        return Cagnote::with('user')->get();
    }

    public function create(array $data): Cagnote
    {
        return Cagnote::create([
            'code' => strtoupper(Str::random(10)),
            'nom' => $data['nom'],
            'description' => $data['description'],
            'montant_objectif' => $data['montant_objectif'],
            'montant_collecte' => 0,
            'date_limite' => $data['date_limite'] ?? now()->addWeeks(2),
            'status' => 'encours',
            'user_id' => $data['user_id'],
        ]);
    }

    public function getById(int $id): ?array
    {
        $cagnote = Cagnote::with('user')->find($id);

        if (!$cagnote) {
            return null;
        }

        $objectif = $cagnote->montant_objectif;
        $collecte = $cagnote->montant_collecte;
        $pourcentage = $objectif > 0 ? round(($collecte / $objectif) * 100, 2) : 0;

        return [
            'id' => $cagnote->id,
            'nom' => $cagnote->nom,
            'description' => $cagnote->description,
            'montant_objectif' => $objectif,
            'montant_collecte' => $collecte,
            'pourcentage' => $pourcentage,
            'user_nomcomplet' => $cagnote->user->nomcomplet ?? null,
            'date_limite' => $cagnote->date_limite,
            'status' => $cagnote->status,
        ];
    }

    public function participer(array $data): array
    {
        $cagnotte = Cagnote::findOrFail($data['cagnotte_id']);
        $solde = Solde::where('user_id', $data['user_id'])->lockForUpdate()->first();

        if (!$solde || $solde->solde < $data['montant']) {
            return [
                'status' => 'error',
                'code' => 400,
                'message' => 'Solde insuffisant.',
                'solde' => $solde?->solde ?? 0
            ];
        }

        DB::beginTransaction();

        try {
            $solde->solde -= $data['montant'];
            $solde->save();

            $cagnotte->montant_collecte += $data['montant'];
            $cagnotte->save();

            Transaction::create([
                'user_id' => $data['user_id'],
                'name' => "Participation à la cagnotte ({$data['montant']} FCFA)",
                'reference' => strtoupper(Str::random(10)),
                'montant' => +$data['montant'],
                'typeoperation' => 'cagnote',
                'status' => 'succes',
            ]);

            DB::commit();

            $objectif = $cagnotte->montant_objectif;
            $pourcentage = $objectif > 0 ? round(($cagnotte->montant_collecte / $objectif) * 100, 2) : 0;

            return [
                'status' => 'success',
                'code' => 200,
                'message' => 'Participation enregistrée avec succès.',
                'nouveau_solde' => $solde->solde,
                'montant_collecte' => $cagnotte->montant_collecte,
                'pourcentage' => $pourcentage,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'code' => 500,
                'message' => 'Erreur lors de la participation.',
                'error' => $e->getMessage(),
            ];
        }
    }
}
