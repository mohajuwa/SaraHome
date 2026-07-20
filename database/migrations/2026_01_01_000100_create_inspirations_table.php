<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspirations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('style');          // مودرن دافئ / سكندنافي ...
            $table->string('tag')->index();    // filter category
            $table->string('accent_color', 9)->default('#C15F3C');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspirations');
    }
};
