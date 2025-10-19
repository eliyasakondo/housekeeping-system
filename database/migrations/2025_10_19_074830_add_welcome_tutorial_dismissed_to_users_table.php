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
            $table->boolean('welcome_tutorial_dismissed')->default(false)->after('remember_token');
            $table->timestamp('welcome_tutorial_shown_at')->nullable()->after('welcome_tutorial_dismissed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['welcome_tutorial_dismissed', 'welcome_tutorial_shown_at']);
        });
    }
};
