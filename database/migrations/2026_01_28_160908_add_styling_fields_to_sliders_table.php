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
            $table->string('social_hover_color')->nullable();
            $table->string('social_icon_color')->nullable();
            $table->string('social_icon_hover_color')->nullable();
            $table->string('nav_hover_color')->nullable();
            $table->string('nav_icon_color')->nullable();
            $table->string('nav_icon_hover_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn([
                'social_hover_color', 'social_icon_color', 'social_icon_hover_color',
                'nav_hover_color', 'nav_icon_color', 'nav_icon_hover_color'
            ]);
        });
    }
};
