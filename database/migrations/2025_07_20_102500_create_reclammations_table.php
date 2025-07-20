<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReclammationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclammations', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->text('objet')->nullable();
            $table->string('reference')->unique();
            $table->text('message');
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->enum('canal', ['google_meet', 'whatsapp_appel', 'appel_telephonique', 'messagerie']);
            $table->enum('statut', ['en_attente', 'traitee', 'fermee'])->default('en_attente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclammations');
    }
}
