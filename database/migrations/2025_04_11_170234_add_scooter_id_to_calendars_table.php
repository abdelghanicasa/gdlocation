<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_scooter_id_to_calendars_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScooterIdToCalendarsTable extends Migration
{
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->unsignedBigInteger('scooter_id')->nullable();  // Ajouter la colonne scooter_id
            
            // Si vous souhaitez ajouter une contrainte de clé étrangère pour scooter_id
            $table->foreign('scooter_id')->references('id')->on('scooters')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropForeign(['scooter_id']);  // Supprimer la contrainte de clé étrangère
            $table->dropColumn('scooter_id');  // Supprimer la colonne
        });
    }
}
