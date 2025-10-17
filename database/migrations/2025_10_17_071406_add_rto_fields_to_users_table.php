<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('website')->nullable()->after('address');
            $table->string('contact_person')->nullable()->after('website');
            $table->boolean('status')->default(true)->after('contact_person');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['website', 'contact_person', 'status']);
        });
    }
};