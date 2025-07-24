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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity_change'); // Positivo para entrada, negativo para saída
            $table->string('reason')->nullable(); // Ex: "Venda Pedido #123", "Ajuste Manual", "Devolução"
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null'); // Quem fez a alteração
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
