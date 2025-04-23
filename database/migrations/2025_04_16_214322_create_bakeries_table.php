<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bakeries', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('latitude', 10, 7);  // 7 casas decimais para maior precisão
            $table->decimal('longitude', 10, 7); // 7 casas decimais para maior precisão
            $table->string('cep', 10); // Aumentando a largura para CEP com hífen
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('phone', 15); // Limite de 15 caracteres para o telefone
            $table->timestamps();

            // Adicionando um índice para o CEP (facilita a busca por CEP)
            $table->index('cep');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bakeries');
    }
};
