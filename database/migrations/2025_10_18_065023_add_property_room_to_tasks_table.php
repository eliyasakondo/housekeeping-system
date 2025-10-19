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
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('property_id')->nullable()->after('is_default')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->after('property_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
            $table->dropForeign(['room_id']);
            $table->dropColumn(['property_id', 'room_id']);
        });
    }
};
