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
        Schema::table('products', function (Blueprint $table) {
            // Certificando que a foreign key existe e aplica a exclusão em cascata
            $table->foreign('bakery_id')
                  ->references('id')
                  ->on('bakeries')
                  ->onDelete('cascade'); // Cascata para deletar produtos quando a confeitaria for deletada
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove a foreign key, revertendo a alteração
            $table->dropForeign(['bakery_id']);
            
            // Se necessário, restaure o relacionamento sem a exclusão em cascata
            $table->foreign('bakery_id')
                  ->references('id')
                  ->on('bakeries');
        });
    }
};
