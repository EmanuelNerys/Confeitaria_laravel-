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
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Aumentando a largura de 'name' e usando 'text' para 'description'
            $table->string('name'); // Campo para o nome do produto
            $table->decimal('price', 8, 2); // Usando 'decimal' para o preço
            $table->text('description'); // Usando 'text' para a descrição, caso seja mais longa
            $table->string('image')->nullable(); // Imagem do produto (pode ser null)
            
            // Adicionando a chave estrangeira para 'bakery_id'
            $table->foreignId('bakery_id')->constrained('bakeries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Removendo a chave estrangeira e a coluna
            $table->dropForeign(['bakery_id']);
            $table->dropColumn('bakery_id');
        });
    }
};
