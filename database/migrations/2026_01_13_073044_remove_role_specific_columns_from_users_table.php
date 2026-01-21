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
        Schema::table('users', function (Blueprint $table) {
            $columnsToRemove = [
                'emergency_contact', 'placement_hours', 'student_status', 'student_availability',
                'coordinator_type', 'notes', 'latitude', 'longitude', 'website', 'contact_person',
                'rto_number', 'code', 'assigned_coordinator_id', 'placement_coordinator_id',
                'sourcing_coordinator_id', 'medical_condition', 'transport', 'placement_data', 'gender'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('emergency_contact')->nullable();
            $table->integer('placement_hours')->nullable();
            $table->enum('student_status', ['active', 'inactive', 'blocked'])->default('active');
            $table->json('student_availability')->nullable();
            $table->enum('coordinator_type', ['sourcing', 'placement'])->nullable();
            $table->text('notes')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('rto_number')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('assigned_coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('placement_coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sourcing_coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('medical_condition')->nullable();
            $table->string('transport')->nullable();
            $table->text('placement_data')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
        });
    }
};
