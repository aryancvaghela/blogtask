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
            $table->string('mobile', 10)->unique()->after('email');
            $table->date('dob')->nullable()->after('mobile');
            $table->enum('gender', ['male', 'female', 'other'])->after('dob');
            $table->string('profile_image')->nullable()->after('gender');
            $table->enum('status', ['active', 'inactive'])->default('inactive')->after('profile_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'dob', 'gender', 'profile_image', 'status']);
        });
    }
};
