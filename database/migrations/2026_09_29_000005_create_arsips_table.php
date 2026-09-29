<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boks_id')->constrained()->restrictOnDelete();
            $table->string('archive_number');
            $table->string('title');
            $table->string('document_type')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->unique(['boks_id', 'archive_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};