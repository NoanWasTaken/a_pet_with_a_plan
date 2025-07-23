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
        Schema::table('users', function (Blueprint $table) {
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->enum('animal_prefere', ['Chien', 'Chat'])->nullable();
            $table->boolean('newsletter')->default(false);
            $table->boolean('promotions')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telephone', 'adresse', 'animal_prefere', 'newsletter', 'promotions']);
        });
    }
};
