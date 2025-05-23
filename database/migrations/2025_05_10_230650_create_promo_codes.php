<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ex: "WELCOME10"
            $table->decimal('discount', 8, 2); // montant ou pourcentage selon type
            $table->date('expires_at')->nullable(); // date d’expiration
            $table->integer('usage_limit')->nullable(); // combien de fois il peut être utilisé
            $table->boolean('active')->default(true); // activé/désactivé
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
