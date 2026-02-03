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
        // Add the "profile_image_path" column to the "users" table if it
        // doesn't already exist.

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'profile_image_path')) {
                $table->string('profile_image_path', 2048)
                    ->nullable()
                    ->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the "profile_image_path" column from the "users" table if it
        // exists.

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_image_path')) {
                $table->dropColumn('profile_image_path');
            }
        });
    }
};
