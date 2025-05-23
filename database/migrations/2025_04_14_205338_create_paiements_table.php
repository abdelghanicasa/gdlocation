<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_paiements_table.php
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calendar_id'); // La clé étrangère vers la table calendars
            $table->decimal('montant', 8, 2);
            $table->string('methode');
            $table->string('reference')->nullable();
            $table->string('statut');
            $table->timestamp('date_paiement')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Définition de la clé étrangère
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }

};
