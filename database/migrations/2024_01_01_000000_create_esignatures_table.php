<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('esignatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('signature_path')->nullable();
            $table->enum('signature_type', ['drawn', 'uploaded']);
            $table->timestamps();
            
            $table->unique('user_id'); // Only one signature per user
        });
    }

    public function down()
    {
        Schema::dropIfExists('esignatures');
    }
};