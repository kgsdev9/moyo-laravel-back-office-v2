<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nomcomplet')->nullable();
            $table->string('telephone')->unique();
            $table->string('contacturgent')->nullable();
            $table->string('contact_urgent')->nullable();
            $table->string('fixe')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('adresse')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cv')->nullable();
            $table->string('profession')->nullable();
            $table->string('description')->nullable();
            // Pièces d'identité
            $table->string('piece_recto')->nullable();
            $table->string('piece_verso')->nullable();

            // Authentification
            $table->string('password')->nullable();
            $table->string('codeSecret')->nullable();
            $table->string('publicKey')->nullable();
            $table->string('qrcode')->unique();

            // Carte bancaire
            $table->string('cvv')->nullable();
            $table->string('numerocarte')->nullable();
            $table->date('dateexpiration')->nullable();
            $table->string('couleur_carte')->nullable();

            // Statut et rôle
            $table->date('confirmated_at')->nullable();
            $table->enum('role', [
                'client',
                'entreprise',
                'ecole',
                'admin',
                'user',
                'developpeur',
                'adminsys',
                'comptable',
                'commercial',
                'rh',
                'invest',
                'controlegestion',
                'promoteur',
                'ambassadeur',
                'directeur',
                'assistant',
                'donateur',
                'formateur',
                'repetiteur',
                'encadreur'
            ])->default('client');
            $table->boolean('statusCompte')->default(false);
            $table->boolean('payment')->default(0);

            // Relations géographiques
            $table->foreignId('ville_id')->nullable()->constrained('villes')->nullOnDelete();
            $table->foreignId('commune_id')->nullable()->constrained('communes')->nullOnDelete();
            $table->foreignId('pays_id')->nullable()->constrained('pays')->nullOnDelete();

            // Spécialité
            $table->foreignId('specialite_id')->nullable()->constrained('specialites')->nullOnDelete();

            // Divers
            $table->date('date_livraison')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
