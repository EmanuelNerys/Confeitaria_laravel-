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
            // Adicionando a coluna bakery_id se não existir
            $table->string('name'); // Aumentando a largura para CEP com hífen
            $table->string('price');
            $table->string('description');
            $table->string('image');
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
            // Remove a chave estrangeira e a coluna
            $table->dropForeign(['bakery_id']);
            $table->dropColumn('bakery_id');
        });
    }
};
