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
        Schema::table('products', function (Blueprint $table) {
            $table->text('top_notes')->nullable();
            $table->text('heart_notes')->nullable();
            $table->text('base_notes')->nullable();
            $table->integer('intensity')->default(50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['top_notes', 'heart_notes', 'base_notes', 'intensity']);
        });
    }
};
