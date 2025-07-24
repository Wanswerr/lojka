<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Cria uma coluna 'id' auto-incremento e chave primária.
            $table->string('name'); // Coluna para o nome do admin.
            $table->string('email')->unique(); // Coluna para o email, que deve ser único na tabela.
            $table->timestamp('email_verified_at')->nullable(); // Opcional, para verificação de email.
            $table->string('password'); // Coluna para a senha (será armazenada com hash).
            $table->rememberToken(); // Coluna para a funcionalidade "Lembrar-me".
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
