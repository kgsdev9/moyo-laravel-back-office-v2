<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMouchard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',             // Identifiant de l'utilisateur
        'nom_appareil',        // Nom de l'appareil
        'identifiant_appareil', // ID unique de l'appareil (UUID, IMEI, etc.)
        'adresse_ip',          // Adresse IP
        'plateforme',          // Plateforme utilisée (Android, iOS, etc.)
        'version_app',         // Version de l'application
        'type_evenement',      // Type d'événement (connexion, modification, suppression…)
        'agent_utilisateur',   // User-Agent (navigateur ou app mobile)
        'valeur_ancienne',     // Ancienne valeur
        'valeur_nouvelle',     // Nouvelle valeur
        'action',              // Action effectuée (ex. : Connexion, Modification profil, etc.)
    ];
}
