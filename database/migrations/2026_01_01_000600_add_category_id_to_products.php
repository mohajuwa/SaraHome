<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Idempotent: a previous partial run may have already added the column.
        if (! Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->nullOnDelete();
            });
        }

        // Category is now normalized into the categories table.
        // SQLite requires dropping the index before the column it covers.
        if (Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropIndex('products_category_index');
            });
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->string('category')->nullable();
        });
    }
};
