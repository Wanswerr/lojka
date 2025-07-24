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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Mercado Pago", "Stripe"
            $table->string('code')->unique(); // Ex: "mercadopago", "stripe"
            $table->boolean('is_active')->default(false);
            $table->json('config')->nullable(); // Para guardar chaves de API, segredos, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
