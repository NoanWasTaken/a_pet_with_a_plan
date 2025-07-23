<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 150);
            $table->text('description');
            $table->text('contenu');
            $table->string('image', 255);
            $table->string('banniere_article', 255);
            $table->dateTime('date_publication');
            $table->unsignedBigInteger('id_utilisateur');
            $table->timestamps();
            
            // Clé étrangère
            $table->foreign('id_utilisateur')->references('id')->on('utilisateur')->onDelete('cascade');
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
