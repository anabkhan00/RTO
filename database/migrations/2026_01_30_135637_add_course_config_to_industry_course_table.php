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
        Schema::table('industry_courses', function (Blueprint $table) {
            $table->json('additional_documents')->nullable()->after('course_id');
            $table->json('placement_slots')->nullable()->after('additional_documents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_courses', function (Blueprint $table) {
            $table->dropColumn(['additional_documents', 'placement_slots']);
        });
    }
};
