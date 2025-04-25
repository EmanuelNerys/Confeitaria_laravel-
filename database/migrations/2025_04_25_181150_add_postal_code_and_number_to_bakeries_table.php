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
        Schema::table('bakeries', function (Blueprint $table) {
            $table->string('postal_code', 9)->after('description');
            $table->string('number', 10)->after('address');
        });
    }
    
    public function down(): void
    {
        Schema::table('bakeries', function (Blueprint $table) {
            $table->dropColumn(['postal_code', 'number']);
        });
    }
    
};
