<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('codefacture')->unique();
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('user_id');
            $table->string('adresse')->nullable();
            $table->decimal('montantlivraison', 15, 2)->default(0);
            $table->date('date_echeance')->nullable();
            $table->decimal('remise', 15, 2)->default(0);
            $table->enum('status', ['progression','regle'])->default('progression');
            $table->decimal('montantht', 15, 2)->default(0);
            $table->decimal('montantttc', 15, 2)->default(0);
            $table->decimal('montanttva', 15, 2)->default(0);
            $table->decimal('montantregle', 15, 2)->default(0);
            $table->decimal('montantrestant', 15, 2)->default(0);
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factures');
    }
}
