<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bakeries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // atualizado de 'nome' para 'name'
            $table->string('description', 20); // novo campo, conforme o formulário
            $table->string('address'); // novo campo, substituindo 'street'
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('image')->nullable(); // campo adicionado para suportar upload de imagem
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bakeries');
    }
};