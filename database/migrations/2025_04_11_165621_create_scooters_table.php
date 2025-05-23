<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scooters', function (Blueprint $table) {
            $table->id();
            $table->string('modele');
            $table->string('plaque_immatriculation')->unique();
            $table->enum('statut', ['disponible', 'en_maintenance', 'reserve', 'hors_service'])->default('disponible');
            $table->string('photo')->nullable();
            $table->integer('kilometrage');
            $table->year('annee');
            $table->text('caracteristiques')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scooters');
    }
};
