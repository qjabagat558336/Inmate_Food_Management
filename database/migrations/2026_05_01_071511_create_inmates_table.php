<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inmates', function (Blueprint $table) {
            $table->id();
            $table->string('inmate_number')->unique(); // e.g. INM-0011
            $table->string('name');
            $table->enum('block', ['Block A', 'Block B', 'Block C', 'Block D']);
            $table->enum('status', ['active', 'released', 'transferred'])->default('active');
            $table->text('dietary_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inmates');
    }
};