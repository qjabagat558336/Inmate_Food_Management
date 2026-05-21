<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('meal_name');
            $table->enum('day', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']);
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 50);
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->index('day');
            $table->index('meal_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};