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
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('kind')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('tos')->nullable();
            $table->string('privacy')->nullable();
            $table->string('web')->nullable();
            $table->string('picture')->nullable();
            $table->json('tags')->nullable();
            $table->json('mini_template')->nullable();
            $table->json('output_template')->nullable();
            $table->json('input_template')->nullable();
            $table->json('secrets')->nullable();
            $table->json('wasm_upload')->nullable();
            $table->string('plugin_input')->nullable();
            $table->string('file_link')->nullable();
            $table->string('payment')->nullable();
            $table->string('author')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugins');
    }
};
