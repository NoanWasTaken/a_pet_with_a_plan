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
            $table->string('devise_preferee', 3)->default('EUR')->after('promotions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilisateur', function (Blueprint $table) {
            $table->dropColumn('devise_preferee');
        });
    }
};
