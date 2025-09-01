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
            // Add admin management fields
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            $table->string('status')->default('active')->after('last_login_at'); // active, suspended, inactive
            $table->text('admin_notes')->nullable()->after('status'); // For admin to add notes about users
            $table->timestamp('email_verified_at')->nullable()->change(); // Ensure this exists
            
            // Add indexes for better performance
            $table->index(['role', 'status']);
            $table->index('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['last_login_at']);
            $table->dropColumn(['last_login_at', 'status', 'admin_notes']);
        });
    }
};
