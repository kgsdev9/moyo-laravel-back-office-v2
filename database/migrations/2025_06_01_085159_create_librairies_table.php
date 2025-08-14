<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrairiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('librairies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('nom');
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->unsignedBigInteger('commune_id')->nullable();
            $table->unsignedBigInteger('pays_id')->nullable();

            $table->boolean('active')->default(true);
            $table->string('nrcccm')->nullable();

            $table->timestamps();

            // Relations éventuelles (optionnelles selon si tu veux ajouter les contraintes)
            $table->foreign('ville_id')->references('id')->on('villes')->onDelete('set null');
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('set null');
            $table->foreign('pays_id')->references('id')->on('pays')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('librairies');
    }
}
