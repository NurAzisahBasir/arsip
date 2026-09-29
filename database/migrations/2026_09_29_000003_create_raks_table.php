<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelurahan_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['kelurahan_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raks');
    }
};