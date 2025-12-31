<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('placement_coordinator_id')->nullable()->after('assigned_coordinator_id');
            $table->unsignedBigInteger('sourcing_coordinator_id')->nullable()->after('placement_coordinator_id');
            
            $table->foreign('placement_coordinator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('sourcing_coordinator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['placement_coordinator_id']);
            $table->dropForeign(['sourcing_coordinator_id']);
            $table->dropColumn(['placement_coordinator_id', 'sourcing_coordinator_id']);
        });
    }
};