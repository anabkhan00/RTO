<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentAssignmentRequest;
use Illuminate\Support\Facades\DB;

class StudentAssignmentSeeder extends Seeder
{
    public function run()
    {
        // First, mark the migration as completed if table exists
        try {
            if (DB::getSchemaBuilder()->hasTable('student_assignment_requests')) {
                $migrationExists = DB::table('migrations')
                    ->where('migration', '2024_01_15_000001_create_student_assignment_requests_table')
                    ->exists();
                
                if (!$migrationExists) {
                    DB::table('migrations')->insert([
                        'migration' => '2024_01_15_000001_create_student_assignment_requests_table',
                        'batch' => 4
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Continue if there's an error
        }

        // Get users with different roles - use existing roles
        $students = User::whereHas('roles', function($query) {
            $query->where('name', 'user');
        })->take(5)->get();
        
        // If no users with 'user' role, get any users
        if ($students->isEmpty()) {
            $students = User::take(5)->get();
        }
        
        $placementCoordinators = User::role('placement_coordinator')->get();
        $sourcingCoordinators = User::role('sourcing_coordinator')->get();
        
        // If no coordinators exist, use admin users
        if ($placementCoordinators->isEmpty()) {
            $placementCoordinators = User::role('admin')->take(1)->get();
        }
        if ($sourcingCoordinators->isEmpty()) {
            $sourcingCoordinators = User::role('admin')->take(1)->get();
        }

        if ($students->isEmpty() || $placementCoordinators->isEmpty() || $sourcingCoordinators->isEmpty()) {
            $this->command->info('Not enough users with required roles. Skipping assignment seeding.');
            return;
        }

        $placementCoordinator = $placementCoordinators->first();
        $sourcingCoordinator = $sourcingCoordinators->first();

        // Create sample assignment requests
        $assignments = [
            [
                'student_id' => $students[0]->id,
                'placement_coordinator_id' => $placementCoordinator->id,
                'sourcing_coordinator_id' => $sourcingCoordinator->id,
                'industry_preference' => 'Healthcare',
                'special_requirements' => 'Prefers morning shifts, has own transport, looking for aged care facilities',
                'status' => 'pending',
                'assigned_at' => now()->subHours(2),
            ],
            [
                'student_id' => $students[1]->id,
                'placement_coordinator_id' => $placementCoordinator->id,
                'sourcing_coordinator_id' => $sourcingCoordinator->id,
                'industry_preference' => 'Technology',
                'special_requirements' => 'Bilingual (Korean), available weekdays',
                'status' => 'in_progress',
                'progress_notes' => 'Contacted 3 IT companies. TechCorp interested - scheduling interview for tomorrow.',
                'assigned_at' => now()->subHours(5),
                'started_at' => now()->subHours(4),
            ],
            [
                'student_id' => $students[2]->id,
                'placement_coordinator_id' => $placementCoordinator->id,
                'sourcing_coordinator_id' => $sourcingCoordinator->id,
                'industry_preference' => 'Retail',
                'special_requirements' => 'Available weekends, previous retail experience, prefers fashion/clothing stores',
                'status' => 'pending',
                'assigned_at' => now()->subDay(),
            ],
        ];

        if (count($students) > 3) {
            $assignments[] = [
                'student_id' => $students[3]->id,
                'placement_coordinator_id' => $placementCoordinator->id,
                'sourcing_coordinator_id' => $sourcingCoordinator->id,
                'industry_preference' => 'Manufacturing',
                'special_requirements' => 'Manual handling certified, available for shift work',
                'status' => 'completed',
                'progress_notes' => 'Successfully placed at Industrial Manufacturing Co. Start date: Next Monday',
                'assigned_at' => now()->subHours(8),
                'started_at' => now()->subHours(6),
                'completed_at' => now()->subHours(2),
            ];
        }

        foreach ($assignments as $assignment) {
            StudentAssignmentRequest::create($assignment);
        }

        $this->command->info('Student assignment requests seeded successfully.');
    }
}