<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_industry_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinator_id')->constrained('users')->onDelete('cascade');
            $table->string('keyword');
            $table->string('industry_name');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_industry_keywords');
    }
};
