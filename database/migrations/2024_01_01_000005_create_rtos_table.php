<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rtos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rto_number')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('website')->nullable();
            $table->string('contact_person');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rtos');
    }
};