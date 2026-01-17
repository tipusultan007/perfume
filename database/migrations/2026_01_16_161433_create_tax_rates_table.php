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
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Display name like NY Sales Tax');
            $table->decimal('rate', 8, 4)->comment('Tax rate in percentage, e.g. 8.875');
            $table->string('state_code', 2)->nullable()->comment('Two letter state code');
            $table->string('zip_code')->nullable()->comment('Optional zip code');
            $table->string('city')->nullable()->comment('Optional city');
            $table->integer('priority')->default(1)->comment('Calculation priority');
            $table->boolean('is_compounded')->default(false);
            $table->boolean('is_shipping_taxable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
    }
};
