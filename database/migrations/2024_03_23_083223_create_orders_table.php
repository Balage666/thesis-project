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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('user_id')->nullable();
            $table->string('status');
            $table->string('full_name');
            $table->string('email');
            $table->string('address_text');
            $table->string('state_or_region');
            $table->string('postal_or_zip_code');
            $table->string('country');
            $table->text('phone_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
