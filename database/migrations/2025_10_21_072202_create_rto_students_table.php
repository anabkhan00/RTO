<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rto_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rto_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign('rto_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['rto_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rto_students');
    }
};