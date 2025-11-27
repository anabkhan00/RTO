<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_industries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('industry_id')->constrained('industries')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['student_id', 'industry_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_industries');
    }
};