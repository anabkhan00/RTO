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
        Schema::table('student_weekly_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('student_weekly_schedules', 'selected_time_slots')) {
                $table->json('selected_time_slots')->nullable()->after('week_end_date');
            }
            if (!Schema::hasColumn('student_weekly_schedules', 'total_hours')) {
                $table->decimal('total_hours', 8, 2)->default(0)->after('hours_assigned');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_weekly_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('student_weekly_schedules', 'selected_time_slots')) {
                $table->dropColumn('selected_time_slots');
            }
            if (Schema::hasColumn('student_weekly_schedules', 'total_hours')) {
                $table->dropColumn('total_hours');
            }
        });
    }
};
