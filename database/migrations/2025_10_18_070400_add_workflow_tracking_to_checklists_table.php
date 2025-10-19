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
        Schema::table('checklists', function (Blueprint $table) {
            // Workflow step: 'tasks', 'inventory', 'photos'
            $table->string('workflow_step')->default('tasks')->after('status');
            
            // Track which room is currently being worked on (for room-by-room progression)
            $table->unsignedBigInteger('current_room_id')->nullable()->after('workflow_step');
            $table->foreign('current_room_id')->references('id')->on('rooms')->onDelete('set null');
            
            // Track when inventory step was completed
            $table->timestamp('inventory_completed_at')->nullable()->after('completed_at');
            
            // Track when tasks step was completed (all rooms done)
            $table->timestamp('tasks_completed_at')->nullable()->after('inventory_completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->dropForeign(['current_room_id']);
            $table->dropColumn(['workflow_step', 'current_room_id', 'inventory_completed_at', 'tasks_completed_at']);
        });
    }
};
