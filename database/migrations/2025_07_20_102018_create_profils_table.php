<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('commune_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->string('nomcomplet');
            $table->string('contacturgent')->nullable();
            $table->string('adresse')->nullable();
            $table->string('piece_recto')->nullable();
            $table->string('piece_verso')->nullable();
            $table->boolean('status')->default(0);
            $table->string('profession')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('commune_id')->references('id')->on('communes')->cascadeOnDelete();
            $table->foreign('ville_id')->references('id')->on('villes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profils');
    }
}
