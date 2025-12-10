<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('industry_weekly_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained('industries')->onDelete('cascade');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->json('selected_time_slots')->nullable();
            $table->decimal('total_hours', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_weekly_schedules');
    }
};
