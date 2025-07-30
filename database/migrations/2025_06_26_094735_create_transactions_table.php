<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('modereglementname')->nullable();
            $table->string('reference')->unique();
            $table->decimal('montant', 12, 2)->default(0);
            $table->string('solderestant')->nullable();
            $table->decimal('fraisoperateur', 12, 2)->default(0);
            $table->decimal('fraisservice', 12, 2)->default(0);
            $table->unsignedBigInteger('modereglement_id')->nullable();
            $table->unsignedBigInteger('ecole_id')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->enum('typeoperation', ['depot', 'retrait', 'transfert', 'scolarite', 'facture', 'paiement', 'debit', 'crediter', 'credit', 'cagnote']);
            $table->enum('status', ['encours', 'succes', 'echec'])->default('encours');
            $table->text('observation')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('recepteur_id')->nullable();
            $table->foreign('modereglement_id')->references('id')->on('mode_reglements')->nullOnDelete();
            $table->foreign('ecole_id')->references('id')->on('ecoles')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->cascadeOnDelete();
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
        Schema::dropIfExists('transactions');
    }
}
