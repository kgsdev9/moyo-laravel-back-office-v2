<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeLignesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_lignes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('article_id');
            $table->integer('quantite')->default(1);
            $table->decimal('remise', 15, 2)->default(0);
            $table->decimal('pu', 15, 2)->default(0); 
            $table->decimal('montantht', 15, 2)->default(0);
            $table->decimal('montanttva', 15, 2)->default(0);
            $table->decimal('montantttc', 15, 2)->default(0);

            // Clés étrangères
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

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
        Schema::dropIfExists('commande_lignes');
    }
}
