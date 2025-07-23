<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('note', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_utilisateur');
            $table->unsignedBigInteger('id_produit');
            $table->integer('note');
            $table->text('commentaire');
            $table->timestamps();
            
            // Clés étrangères
            $table->foreign('id_utilisateur')->references('id')->on('utilisateur')->onDelete('cascade');
            $table->foreign('id_produit')->references('id')->on('produit')->onDelete('cascade');
            
            // Index unique pour éviter qu'un utilisateur note plusieurs fois le même produit
            $table->unique(['id_utilisateur', 'id_produit']);
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('note');
    }
};
