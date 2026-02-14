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
        Schema::table('popups', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
            $table->text('description')->nullable()->after('subtitle');
            $table->string('cta_text')->nullable()->after('link');
            $table->string('template_id')->default('luxury-minimalist')->after('cta_text');
            $table->boolean('show_newsletter')->default(false)->after('template_id');
            $table->string('font_family')->default('Cormorant Garamond')->after('show_newsletter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('popups', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'description', 'cta_text', 'template_id', 'show_newsletter', 'font_family']);
        });
    }
};
