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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('module')->nullable();     // Ex : "Cagnottes", "Utilisateurs"
            $table->text('val_ancienne')->nullable(); // Ancienne valeur (avant modification)
            $table->text('val_nouvelle')->nullable(); // Nouvelle valeur (après modification)
            $table->string('ip')->nullable();         // IP de l'utilisateur
            $table->text('navigateur')->nullable();   // User-Agent ou device
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
