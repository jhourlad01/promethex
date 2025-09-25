<?php

namespace Database\Migrations;

use Framework\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddEmailVerificationTokenToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->schema()->table('users', function (Blueprint $table) {
            $table->string('email_verification_token')->nullable()->after('email_verified_at');
            $table->index('email_verification_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->schema()->table('users', function (Blueprint $table) {
            $table->dropIndex(['email_verification_token']);
            $table->dropColumn('email_verification_token');
        });
    }
}
