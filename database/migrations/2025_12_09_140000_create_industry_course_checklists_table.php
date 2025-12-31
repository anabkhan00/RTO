<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industry_course_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->json('checklist_ids');
            $table->timestamps();
            
            $table->unique(['industry_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industry_course_checklists');
    }
};