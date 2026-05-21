<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            if (!Schema::hasColumn('meals', 'meal_type')) {
                $table->string('meal_type', 100)->nullable()->after('meal_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            if (Schema::hasColumn('meals', 'meal_type')) {
                $table->dropColumn('meal_type');
            }
        });
    }
};