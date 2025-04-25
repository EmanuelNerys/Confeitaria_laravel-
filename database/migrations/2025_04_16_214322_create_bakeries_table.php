<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bakeries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 20);
            $table->string('postal_code', 9); // Novo campo: CEP
            $table->string('address');
            $table->string('number', 10);     // Adicionado
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bakeries');
    }
};
