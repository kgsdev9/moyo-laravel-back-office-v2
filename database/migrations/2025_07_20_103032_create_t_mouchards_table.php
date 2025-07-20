<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMouchardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mouchards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nom_appareil')->nullable();
            $table->string('identifiant_appareil')->nullable();
            $table->string('adresse_ip')->nullable();
            $table->string('plateforme')->nullable();
            $table->string('version_app')->nullable();
            $table->string('type_evenement')->nullable();
            $table->text('agent_utilisateur')->nullable();
            $table->text('valeur_ancienne')->nullable();
            $table->text('valeur_nouvelle')->nullable();
            $table->string('action')->nullable();
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
        Schema::dropIfExists('t_mouchards');
    }
}
