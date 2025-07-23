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
        Schema::create('chat_responses', function (Blueprint $table) {
            $table->id();
            $table->string('trigger'); // Mot-clé ou pattern qui déclenche cette réponse
            $table->text('response'); // Réponse du bot
            $table->json('keywords')->nullable(); // Mots-clés associés pour la recherche
            $table->json('product_ids')->nullable(); // IDs des produits à recommander
            $table->enum('category', ['symptom', 'general', 'product', 'emergency']); // Catégorie
            $table->integer('priority')->default(0); // Priorité pour l'ordre des réponses
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['trigger', 'is_active']);
            $table->index(['category', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_responses');
    }
};
