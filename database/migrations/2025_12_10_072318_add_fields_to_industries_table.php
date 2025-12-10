<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->enum('industry_status', ['active', 'inactive', 'blocked'])->default('active')->after('status');
            $table->json('course_ids')->nullable()->after('industry_status');
            $table->json('checklist_ids')->nullable()->after('course_ids');
            $table->json('availability')->nullable()->after('checklist_ids');
            $table->text('notes')->nullable()->after('availability');
        });
    }

    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->dropColumn(['industry_status', 'course_ids', 'checklist_ids', 'availability', 'notes']);
        });
    }
};