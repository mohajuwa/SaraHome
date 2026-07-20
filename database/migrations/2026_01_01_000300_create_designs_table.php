<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->json('palette');            // [{name, hex}]
            $table->json('furniture');          // [{name, price, note}]
            $table->json('lighting')->nullable(); // [string]
            $table->text('summary')->nullable();
            $table->unsignedInteger('estimated_cost')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
