<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->index();   // كنب / طاولات / إضاءة ...
            $table->string('style')->nullable();    // مودرن دافئ / سكندنافي ...
            $table->unsignedInteger('price');
            $table->string('image_path');           // /images/products/xxx.svg
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
