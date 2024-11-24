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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('mobile', 30)->nullable();
            $table->string('website',50)->nullable();
            $table->string('facebook')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('gender',30)->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('current_city')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('primary_lang')->nullable();
            $table->string('secondary_lang')->nullable();
            $table->string('favorite_quote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
