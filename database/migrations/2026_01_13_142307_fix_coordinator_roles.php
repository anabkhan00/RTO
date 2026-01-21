<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all users with role 'coordinator'
        $coordinators = User::where('role', 'coordinator')->get();

        foreach ($coordinators as $coordinator) {
            // Assign placement_coordinator role as default and update role column
            $coordinator->syncRoles(['placement_coordinator']);
            $coordinator->update(['role' => 'placement_coordinator']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert coordinators back to generic 'coordinator' role
        $coordinators = User::whereIn('role', ['placement_coordinator', 'sourcing_coordinator'])->get();
        
        foreach ($coordinators as $coordinator) {
            $coordinator->syncRoles([]);
            $coordinator->update(['role' => 'coordinator']);
        }
    }
};
