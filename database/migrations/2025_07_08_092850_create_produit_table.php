<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('produit', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 72);
            $table->integer('prix'); // Prix en centimes
            $table->text('description');
            $table->string('image', 255);
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('produit');
    }
};
