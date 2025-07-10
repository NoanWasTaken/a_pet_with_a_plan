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
        Schema::table('commande', function (Blueprint $table) {
            $table->integer('total')->default(0)->after('date_commande'); // Total en centimes
            $table->enum('statut', ['en_attente', 'confirmee', 'en_cours', 'livree', 'annulee', 'echouee'])->default('en_attente')->after('total');
            $table->string('stripe_session_id')->nullable()->after('statut');
            $table->string('stripe_payment_intent')->nullable()->after('stripe_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commande', function (Blueprint $table) {
            $table->dropColumn(['total', 'statut', 'stripe_session_id', 'stripe_payment_intent']);
        });
    }
};
