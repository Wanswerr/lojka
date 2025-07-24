<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Adiciona a chave estrangeira para email_templates
            // É 'nullable' porque nem todo produto precisa de um e-mail de entrega (ex: produtos físicos)
            $table->foreignId('email_template_id')->nullable()->constrained('email_templates')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['email_template_id']);
            $table->dropColumn('email_template_id');
        });
    }
};