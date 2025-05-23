<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('age_conducteur')->nullable();
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();

            $table->string('etat_paiement')->default('en_attente'); // ex: en_attente, payé, refusé
            $table->string('etat_reservation')->default('en_cours'); // ex: en_cours, confirmée, annulée, terminée

            $table->integer('nombre_jours')->default(1);

            $table->string('nom');
            $table->string('prenom');
            $table->string('tel');
            $table->string('adresse')->nullable();
            $table->string('email');
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();

            // Champs supplémentaires utiles
            $table->string('reference')->unique(); // pour un identifiant de réservation unique
            $table->text('notes_admin')->nullable(); // note interne pour le staff/admin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
