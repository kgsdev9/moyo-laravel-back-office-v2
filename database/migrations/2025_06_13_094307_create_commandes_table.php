<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->integer('qtecmde')->default(0);
            $table->decimal('montantht', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('commune_id');
            $table->string('adresse')->nullable();
            $table->decimal('montantlivraison', 15, 2)->default(0);
            $table->date('datelivraison')->nullable();
            $table->date('date_echeance')->nullable();
            $table->decimal('remise', 15, 2)->default(0);
            $table->enum('status', ['encours', 'livre', 'echec'])->default('encours');
            $table->decimal('montantttc', 15, 2)->default(0);
            $table->decimal('montanttva', 15, 2)->default(0);
            $table->decimal('montantregle', 15, 2)->default(0);
            $table->decimal('montantrestant', 15, 2)->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');
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
        Schema::dropIfExists('commandes');
    }
}
