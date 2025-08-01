<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfants', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('matricule')->unique();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('ecole_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->unsignedBigInteger('pays_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('ecole_id')->references('id')->on('ecoles')->nullOnDelete();
            $table->foreign('ville_id')->references('id')->on('villes')->cascadeOnDelete();
            $table->foreign('pays_id')->references('id')->on('pays')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('enfants');
    }
}
