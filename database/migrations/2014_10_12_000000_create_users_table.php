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
            $table->string('name')->nullable();
            $table->string('telephone')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('password')->nullable();
            $table->string('codeSecret')->nullable();
            $table->string('publicKey')->nullable();
            $table->string('qrcode')->unique();
            $table->date('confirmated_at')->nullable();
            $table->enum('role', ['client', 'entreprise', 'ecole', 'admin', 'user', 'developpeur', 'adminsys', 'comptable', 'commercial', 'rh', 'invest', 'controlegestion','directeur', 'assistant'])->default('client');
            $table->boolean('statusCompte')->default(false);
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
