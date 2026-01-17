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
            $table->decimal('sale_price', 10, 2)->nullable()->after('base_price');
            $table->string('gender')->nullable()->after('status'); // male, female, unisex
            $table->string('concentration')->nullable()->after('gender'); // EDP, EDT, etc.
            $table->string('season')->nullable()->after('concentration');
            
            // Ensure note fields exist (using unless to check if column exists would be cleaner, 
            // but in a fresh migration or if we know schema, we just add new ones or rely on checks)
            // Assuming notes might already exist from previous check, but let's be safe.
            // If they exist, this might fail, but checking the Product model showed they fillable, so they might be there.
            // Let's check schema first? No, rely on "if not exists" logic or just add sale_price + others if missing.
            // Given the previous DESCRIBE output was truncated, let's assume they might exist.
            // Actually, best practice: check column existence.
            
            if (!Schema::hasColumn('products', 'top_notes')) {
                $table->text('top_notes')->nullable();
            }
            if (!Schema::hasColumn('products', 'heart_notes')) {
                $table->text('heart_notes')->nullable();
            }
            if (!Schema::hasColumn('products', 'base_notes')) {
                $table->text('base_notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sale_price', 'gender', 'concentration', 'season', 'top_notes', 'heart_notes', 'base_notes']);
        });
    }
};
