<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, create the detail tables
        $this->createRtoDetails();
        $this->createCoordinatorDetails();
        $this->updateStudentDetails();

        // Then migrate data
        $this->migrateRtoData();
        $this->migrateCoordinatorData();
        $this->migrateStudentData();
    }

    private function createRtoDetails(): void
    {
        if (!Schema::hasTable('rto_details')) {
            Schema::create('rto_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('rto_number')->nullable();
                $table->string('code')->nullable();
                $table->string('website')->nullable();
                $table->string('contact_person')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->text('notes')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->timestamps();
            });
        }
    }

    private function createCoordinatorDetails(): void
    {
        if (!Schema::hasTable('coordinator_details')) {
            Schema::create('coordinator_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('code')->nullable();
                $table->timestamps();
            });
        }
    }

    private function updateStudentDetails(): void
    {
        Schema::table('student_details', function (Blueprint $table) {
            if (!Schema::hasColumn('student_details', 'student_status')) {
                $table->enum('student_status', ['active', 'inactive', 'blocked'])->default('active');
            }
            if (!Schema::hasColumn('student_details', 'student_availability')) {
                $table->json('student_availability')->nullable();
            }
            if (!Schema::hasColumn('student_details', 'assigned_coordinator_id')) {
                $table->foreignId('assigned_coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('student_details', 'placement_coordinator_id')) {
                $table->foreignId('placement_coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('student_details', 'sourcing_coordinator_id')) {
                $table->foreignId('sourcing_coordinator_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('student_details', 'medical_condition')) {
                $table->text('medical_condition')->nullable();
            }
            if (!Schema::hasColumn('student_details', 'transport')) {
                $table->string('transport')->nullable();
            }
            if (!Schema::hasColumn('student_details', 'placement_data')) {
                $table->text('placement_data')->nullable();
            }
            if (!Schema::hasColumn('student_details', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable();
            }
        });
    }

    private function migrateRtoData(): void
    {
        $rtoUsers = DB::table('users')->where('role', 'rto')->get();

        foreach ($rtoUsers as $user) {
            DB::table('rto_details')->insertOrIgnore([
                'user_id' => $user->id,
                'rto_number' => $user->rto_number ?? null,
                'code' => $user->code ?? null,
                'website' => $user->website ?? null,
                'contact_person' => $user->contact_person ?? null,
                'status' => $user->status ?? 'active',
                'notes' => $user->notes ?? null,
                'latitude' => $user->latitude ?? null,
                'longitude' => $user->longitude ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function migrateCoordinatorData(): void
    {
        $coordinatorUsers = DB::table('users')->where('role', 'coordinator')->get();

        foreach ($coordinatorUsers as $user) {
            DB::table('coordinator_details')->insertOrIgnore([
                'user_id' => $user->id,
                'coordinator_type' => $user->coordinator_type ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function migrateStudentData(): void
    {
        $studentUsers = DB::table('users')->where('role', 'user')->get();

        foreach ($studentUsers as $user) {
            // Update existing student_details or create new ones
            $existingDetail = DB::table('student_details')->where('user_id', $user->id)->first();

            $studentData = [
                'student_status' => $user->student_status ?? 'active',
                'student_availability' => $user->student_availability ?? null,
                'assigned_coordinator_id' => $user->assigned_coordinator_id ?? null,
                'placement_coordinator_id' => $user->placement_coordinator_id ?? null,
                'sourcing_coordinator_id' => $user->sourcing_coordinator_id ?? null,
                'medical_condition' => $user->medical_condition ?? null,
                'transport' => $user->transport ?? null,
                'placement_data' => $user->placement_data ?? null,
                'gender' => $user->gender ?? null,
                'updated_at' => now(),
            ];

            if ($existingDetail) {
                DB::table('student_details')
                    ->where('user_id', $user->id)
                    ->update($studentData);
            } else {
                $studentData['user_id'] = $user->id;
                $studentData['created_at'] = now();
                DB::table('student_details')->insert($studentData);
            }
        }
    }

    public function down(): void
    {
        // Restore data back to users table if needed
        Schema::dropIfExists('rto_details');
        Schema::dropIfExists('coordinator_details');

        // Remove added columns from student_details
        Schema::table('student_details', function (Blueprint $table) {
            $columns = [
                'student_status', 'student_availability', 'assigned_coordinator_id',
                'placement_coordinator_id', 'sourcing_coordinator_id', 'medical_condition',
                'transport', 'placement_data', 'gender'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('student_details', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
