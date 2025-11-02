<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ClearSampleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clear {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all sample data from database, keeping only 3 essential users (1 admin, 1 owner, 1 housekeeper)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🗑️  Database Cleanup Tool');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        if (!$this->option('force')) {
            $this->warn('⚠️  WARNING: This will delete ALL data except 3 users!');
            $this->warn('   - 1 Admin user');
            $this->warn('   - 1 Owner user');
            $this->warn('   - 1 Housekeeper user');
            $this->newLine();
            
            if (!$this->confirm('Do you want to continue?')) {
                $this->info('❌ Operation cancelled.');
                return 1;
            }
        }

        $this->info('🔄 Starting cleanup...');
        $this->newLine();

        try {
            DB::beginTransaction();

            // Step 1: Delete all checklists and related data
            $this->info('📋 Deleting checklists and items...');
            $this->deleteIfExists('checklist_photos');
            $this->deleteIfExists('checklist_items');
            $this->deleteIfExists('checklists');
            $this->info('✅ Checklists cleared');

            // Step 2: Delete all properties and related data
            $this->info('🏢 Deleting properties, rooms, and tasks...');
            $this->deleteIfExists('room_task');
            $this->deleteIfExists('rooms');
            $this->deleteIfExists('properties');
            $this->info('✅ Properties cleared');

            // Step 3: Delete all tasks
            $this->info('📝 Deleting tasks...');
            $this->deleteIfExists('tasks');
            $this->info('✅ Tasks cleared');

            // Step 4: Keep only 3 users (1 of each role)
            $this->info('👥 Cleaning up users...');
            
            // Get one user of each role
            $adminId = User::where('role', 'admin')->first()?->id;
            $ownerId = User::where('role', 'owner')->first()?->id;
            $housekeeperId = User::where('role', 'housekeeper')->first()?->id;

            $keepUserIds = array_filter([$adminId, $ownerId, $housekeeperId]);

            if (count($keepUserIds) < 3) {
                $this->error('❌ ERROR: Not enough users found!');
                $this->error('   Please ensure you have at least 1 admin, 1 owner, and 1 housekeeper.');
                DB::rollBack();
                return 1;
            }

            // Delete all users except the 3 we want to keep
            $deletedUsers = User::whereNotIn('id', $keepUserIds)->delete();
            $this->info("✅ Users cleaned (kept 3, deleted {$deletedUsers})");

            // Step 5: Clean up sessions
            $this->info('🔐 Cleaning sessions...');
            $this->deleteIfExists('sessions');
            $this->info('✅ Sessions cleared');

            DB::commit();

            $this->newLine();
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('✅ Database cleanup completed successfully!');
            $this->newLine();
            
            $this->info('📊 Remaining users:');
            $users = User::all();
            foreach ($users as $user) {
                $this->line("   • {$user->name} ({$user->role}) - {$user->email}");
            }
            
            $this->newLine();
            $this->info('🎉 Your client can now start fresh!');
            
            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Delete from table if it exists
     */
    private function deleteIfExists(string $table): void
    {
        try {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->delete();
            }
        } catch (\Exception $e) {
            // Silently ignore if table doesn't exist
        }
    }
}
