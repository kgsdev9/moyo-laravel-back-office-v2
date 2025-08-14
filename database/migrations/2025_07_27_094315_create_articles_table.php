<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('libelle');
            $table->string('quantite');
            $table->text('description')->nullable();
            $table->decimal('pu', 12, 2);
            $table->boolean('disponibilite')->default(1);
            $table->timestamps();
        });
    }




    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
