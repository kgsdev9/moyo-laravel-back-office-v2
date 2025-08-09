<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Solde;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PreleverAbonnementMoyo extends Command
{
    protected $signature = 'abonnement:prelever';
    protected $description = 'Prélève automatiquement les frais d’abonnement trimestriels Moyo';

    public function handle()
    {
        $this->info('Début du prélèvement automatique');

        // Frais trimestriels pour une année académique (Jan-Dec)
        $fraisParTrimestre = [
            1 => 1500,
            2 => 1500,
            3 => 2000,
        ];

        $now = Carbon::now();

        User::chunk(100, function ($users) use ($fraisParTrimestre, $now) {

            foreach ($users as $user) {
                $solde = Solde::firstWhere('user_id', $user->id);
                if (!$solde) {
                    $this->warn("Pas de solde pour user {$user->id}, passage au suivant.");
                    continue;
                }

                // Si activation pas faite (payment = 0), facturer l'activation 2000 FCFA
                if (!$user->payment) {
                    if ($solde->solde < 2000) {
                        $this->warn("Solde insuffisant pour activation user {$user->id}");
                        continue;
                    }

                    DB::transaction(function () use ($solde, $user) {
                        $solde->solde -= 2000;
                        $solde->save();

                        Transaction::create([
                            'user_id' => $user->id,
                            'name' => "Frais d'activation compte Moyo",
                            'reference' => uniqid('ACTIV-'),
                            'montant' => -2000,
                            'typeoperation' => 'activation',
                            'status' => 'succes',
                        ]);

                        $user->payment = 1; // activation faite
                        $user->dernier_paiement_abonnement = now(); // date activation = date dernier paiement
                        $user->trimestres_impayes = 0;
                        $user->save();

                        $this->info("Activation facturée pour user {$user->id}");
                    });

                    continue; // passe au user suivant
                }

                // Gestion prélèvement trimestriel seulement pour les users activés
                $lastPaymentDate = $user->dernier_paiement_abonnement ? Carbon::parse($user->dernier_paiement_abonnement) : Carbon::parse($user->created_at);

                // On calcule combien de trimestres écoulés depuis dernier paiement, basé sur année académique Jan-Dec
                $monthsElapsed = $lastPaymentDate->diffInMonths($now);
                $trimestresPasses = intdiv($monthsElapsed, 3);

                if ($trimestresPasses <= 0) {
                    continue; // rien à facturer
                }

                $totalTrimestresDues = $user->trimestres_impayes + $trimestresPasses;
                $totalTrimestresDues = min($totalTrimestresDues, 3); // max 3 trimestres impayés

                // Calcul du montant total à facturer en fonction du trimestre dans l'année académique
                $montantTotal = 0;

                // On identifie le trimestre en cours dans l'année académique (janvier à décembre)
                // Exemple: mois 0-2 = trim 1, 3-5 = trim 2, 6-8 = trim 3, 9-11 = trim 1 de l'année suivante (cycle)
                $moisDernierPaiement = $lastPaymentDate->month; // 1 à 12
                // Calcule le trimestre (1 à 3) dans le cycle académique
                $trimestreDernierPaiement = intdiv(($moisDernierPaiement - 1), 3) + 1;

                for ($i = 0; $i < $totalTrimestresDues; $i++) {
                    // Trimestre facturé actuel dans le cycle (1,2,3) puis revient à 1
                    $trimToFacturer = (($trimestreDernierPaiement + $i - 1) % 3) + 1;
                    $montantTotal += $fraisParTrimestre[$trimToFacturer];
                }

                // Mise à jour tentative même en cas d'échec
                $user->dernier_essai_prelevement = $now;
                $user->save();

                if ($solde->solde < $montantTotal) {
                    $user->trimestres_impayes = $totalTrimestresDues;
                    $user->save();
                    $this->warn("Solde insuffisant pour user {$user->id}, trimestres impayés mis à jour: {$totalTrimestresDues}");
                    continue;
                }

                DB::transaction(function () use ($solde, $montantTotal, $user) {
                    $solde->solde -= $montantTotal;
                    $solde->save();

                    Transaction::create([
                        'user_id' => $user->id,
                        'name' => "Frais d’abonnement Moyo trimestriels",
                        'reference' => uniqid('ABONN-'),
                        'montant' => -$montantTotal,
                        'typeoperation' => 'abonnement',
                        'status' => 'succes',
                    ]);

                    $user->dernier_paiement_abonnement = now();
                    $user->trimestres_impayes = 0;
                    $user->save();
                });

                $this->info("Prélèvement de {$montantTotal} FCFA effectué pour user {$user->id}.");
            }
        });

        $this->info('Fin du prélèvement automatique');
    }
}
