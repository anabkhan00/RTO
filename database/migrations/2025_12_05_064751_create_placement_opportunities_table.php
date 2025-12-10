<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained()->onDelete('cascade');
            $table->foreignId('sourcing_coordinator_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_slots');
            $table->integer('filled_slots')->default(0);
            $table->text('requirements')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_opportunities');
    }
};