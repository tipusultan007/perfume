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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('bg_color')->default('#FDFCF8');
            $table->string('accent_color')->default('#D4AF37'); // Gold
            $table->string('title_color')->default('#111827'); // Gray-900
            $table->string('description_color')->default('#6B7280'); // Gray-500
            $table->string('price_color')->default('#111827');
            $table->string('social_color')->default('#111827');
            $table->string('nav_color')->default('#111827');
            $table->string('line_color')->default('#111827');
            $table->string('ui_theme')->default('dark'); // dark/light toggle
            $table->string('price')->nullable();
            $table->text('top_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn([
                'bg_color', 'accent_color', 'title_color', 'description_color',
                'price_color', 'social_color', 'nav_color', 'line_color',
                'ui_theme', 'price', 'top_notes'
            ]);
        });
    }
};
