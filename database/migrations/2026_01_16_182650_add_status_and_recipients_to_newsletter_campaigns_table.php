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
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('content'); // draft, sending, sent, error
            $table->string('recipient_type')->nullable()->after('status');
            $table->json('target_recipients')->nullable()->after('recipient_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter_campaigns', function (Blueprint $table) {
            $table->dropColumn(['status', 'recipient_type', 'target_recipients']);
        });
    }
};
