<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_weekly_schedules', function (Blueprint $table) {
            $table->json('selected_time_slots')->nullable()->after('hours_assigned');
        });
    }

    public function down(): void
    {
        Schema::table('student_weekly_schedules', function (Blueprint $table) {
            $table->dropColumn('selected_time_slots');
        });
    }
};