<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            if (!Schema::hasColumn('meals', 'quantity')) {
                $table->decimal('quantity', 10, 2)->after('day');
            }
            if (!Schema::hasColumn('meals', 'unit')) {
                $table->string('unit', 50)->after('quantity');
            }
            if (!Schema::hasColumn('meals', 'price')) {
                $table->decimal('price', 10, 2)->after('unit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'unit', 'price']);
        });
    }
};