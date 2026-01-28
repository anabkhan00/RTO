<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_assignment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('placement_coordinator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sourcing_coordinator_id')->constrained('users')->onDelete('cascade');
            $table->string('industry_preference')->nullable();
            $table->text('special_requirements')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('progress_notes')->nullable();
            $table->timestamp('assigned_at');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['sourcing_coordinator_id', 'status'], 'sar_sourcing_status_idx');
            $table->index(['placement_coordinator_id', 'status'], 'sar_placement_status_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_assignment_requests');
    }
};