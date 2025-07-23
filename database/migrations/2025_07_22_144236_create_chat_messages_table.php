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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->enum('type', ['user', 'bot']); // Type de message
            $table->text('message'); // Contenu du message
            $table->json('metadata')->nullable(); // Données supplémentaires (produits recommandés, etc.)
            $table->timestamps();
            
            $table->foreign('session_id')->references('id')->on('chat_sessions')->onDelete('cascade');
            $table->index(['session_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
