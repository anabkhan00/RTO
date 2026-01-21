<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('contact_person');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('website')->nullable();
            $table->boolean('status')->default(true);
            $table->enum('industry_status', ['active', 'inactive', 'blocked'])->default('active');
            $table->json('course_ids')->nullable();
            $table->json('checklist_ids')->nullable();
            $table->json('availability')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
