<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->string('nom');
            $table->string('url_logo')->nullable();
            $table->string('email');
            $table->string('adresse')->nullable();
            $table->string('contactrh');
            $table->string('siteweb')->nullable();

            $table->unsignedBigInteger('ville_id')->nullable();
            $table->unsignedBigInteger('pays_id')->nullable();

            $table->foreign('ville_id')->references('id')->on('villes')->cascadeOnDelete();
            $table->foreign('pays_id')->references('id')->on('pays')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *  id        Int    @id @default(autoincrement())

     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entreprises');
    }
}
