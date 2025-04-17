<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bakery_id')->constrained()->onDelete('cascade'); // Relacionamento com a confeitaria
            $table->string('name'); // Nome do produto
            $table->decimal('price', 10, 2); // Preço com 2 casas decimais
            $table->text('description'); // Descrição do produto
            $table->json('images')->nullable(); // Armazenando as URLs ou metadados das imagens como JSON
            $table->timestamps();

            // Índices adicionais
            $table->index('bakery_id');  // Índice para o campo bakery_id (para otimizar as consultas relacionadas)
            $table->index('price');      // Caso haja necessidade de filtrar produtos por preço
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
