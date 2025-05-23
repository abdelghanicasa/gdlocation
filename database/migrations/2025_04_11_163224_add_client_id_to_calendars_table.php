<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToCalendarsTable extends Migration
{
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(); // Ajoute la colonne client_id
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); // Crée la contrainte de clé étrangère
        });
    }

    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropForeign(['client_id']); // Supprime la contrainte de clé étrangère
            $table->dropColumn('client_id'); // Supprime la colonne client_id
        });
    }
}
