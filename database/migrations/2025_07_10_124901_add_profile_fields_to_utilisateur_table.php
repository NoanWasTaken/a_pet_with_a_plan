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
        Schema::table('utilisateur', function (Blueprint $table) {
            $table->string('telephone', 20)->nullable()->after('statut');
            $table->text('adresse')->nullable()->after('telephone');
            $table->enum('animal_prefere', ['Chien', 'Chat'])->nullable()->after('adresse');
            $table->boolean('newsletter')->default(false)->after('animal_prefere');
            $table->boolean('promotions')->default(false)->after('newsletter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateur', function (Blueprint $table) {
            $table->dropColumn(['telephone', 'adresse', 'animal_prefere', 'newsletter', 'promotions']);
        });
    }
};
