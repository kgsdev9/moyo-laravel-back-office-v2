<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('codemembre')->unique();
            $table->string('phone')->unique();
            $table->string('qrcode')->unique();
            $table->string('email')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('piece_avant')->nullable();
            $table->string('piece_arriere')->nullable();
            $table->string('pin'); 
            $table->boolean('active')->default(false); 
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
        Schema::dropIfExists('users');
    }
}
