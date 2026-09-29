<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rak_id')->constrained()->restrictOnDelete();
            $table->string('code');
            $table->unsignedSmallInteger('year_start')->nullable();
            $table->unsignedSmallInteger('year_end')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['rak_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boks');
    }
};