<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            if (!Schema::hasColumn('ingredients', 'quantity')) {
                $table->decimal('quantity', 10, 2)->default(0)->after('name');
            }
            if (!Schema::hasColumn('ingredients', 'unit')) {
                $table->string('unit', 50)->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('ingredients', 'price_per_unit')) {
                $table->decimal('price_per_unit', 10, 2)->default(0)->after('unit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('ingredients', 'quantity'))       $columns[] = 'quantity';
            if (Schema::hasColumn('ingredients', 'unit'))           $columns[] = 'unit';
            if (Schema::hasColumn('ingredients', 'price_per_unit')) $columns[] = 'price_per_unit';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};