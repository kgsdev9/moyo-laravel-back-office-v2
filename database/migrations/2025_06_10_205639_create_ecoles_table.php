<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecoles', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('sigle')->nullable();
            $table->string('code')->nullable();
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->string('siteweb')->nullable();
            $table->string('rib')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fixe')->nullable();
            $table->string('logo')->nullable();
            $table->string('num_rccm')->nullable();
            $table->boolean('active')->default(false);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('category_school_id')->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('ecoles');
    }
}
