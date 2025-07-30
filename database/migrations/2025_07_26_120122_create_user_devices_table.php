<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->foreignId('userutilisateur_id')->constrained('users')->onDelete('cascade');
            $table->string('nom_appareil')->nullable();
            $table->string('plateforme')->nullable();          // Ex : Android, Windows
            $table->string('navigateur')->nullable();          // Ex : Chrome, Safari
            $table->string('adresse_ip')->nullable();
            $table->text('agent_utilisateur')->nullable();     // User-Agent complet
            $table->boolean('actif')->default(true);       // Appareil toujours connecté ?
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
        Schema::dropIfExists('user_devices');
    }
}
