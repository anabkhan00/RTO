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
        Schema::create('coordinator_rto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rto_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['coordinator_id', 'rto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinator_rto');
    }
};
