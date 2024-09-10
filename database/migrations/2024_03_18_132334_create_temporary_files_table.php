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
        Schema::create('temporary_files', function (Blueprint $table) {
            $table->string('name_to_store')->unique()->index();
            $table->string('name');
            $table->string('path');
            $table->string('url');
            $table->integer('size')->nullable();
            $table->binary('thumbnail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_files');
    }
};
