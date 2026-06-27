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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Display name like Standard Shipping');
            $table->decimal('cost', 8, 2)->default(0)->comment('Shipping cost');
            $table->string('state_code', 2)->nullable()->comment('Two letter state code');
            $table->string('zip_code')->nullable()->comment('Optional zip code override');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
