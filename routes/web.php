<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CalendarController as AdminCalendarController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ChecklistController as AdminChecklistController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\PropertyController;
use App\Http\Controllers\Owner\CalendarController as OwnerCalendarController;
use App\Http\Controllers\Owner\HousekeeperController as OwnerHousekeeperController;
use App\Http\Controllers\Owner\RoomController as OwnerRoomController;
use App\Http\Controllers\Owner\TaskController as OwnerTaskController;
use App\Http\Controllers\Owner\ChecklistController as OwnerChecklistController;
use App\Http\Controllers\Housekeeper\DashboardController as HousekeeperDashboardController;
use App\Http\Controllers\Housekeeper\ChecklistController;
use App\Http\Controllers\Housekeeper\CalendarController as HousekeeperCalendarController;

Route::get('/', function () {
    return redirect('/login');
});

// Auth routes with registration disabled (users created by admin only)
Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('properties', AdminPropertyController::class);
    Route::resource('tasks', AdminTaskController::class);
    Route::resource('rooms', AdminRoomController::class);
    
    // Checklist management
    Route::get('/checklists', [AdminChecklistController::class, 'index'])->name('checklists.index');
    Route::get('/checklists/{checklist}', [AdminChecklistController::class, 'show'])->name('checklists.show');
    Route::delete('/checklists/{checklist}', [AdminChecklistController::class, 'destroy'])->name('checklists.destroy');
    
    // Calendar routes
    Route::get('/calendar', [AdminCalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [AdminCalendarController::class, 'getEvents'])->name('calendar.events');
    Route::get('/calendar/checklist/{checklist}', [AdminCalendarController::class, 'show'])->name('calendar.show');
    
    // Settings routes
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [AdminSettingsController::class, 'reset'])->name('settings.reset');
    
    // Welcome tutorial dismissal
    Route::post('/welcome-tutorial/dismiss', [AdminDashboardController::class, 'dismissWelcomeTutorial'])->name('welcome.dismiss');
});

// Owner Routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/welcome-tutorial/dismiss', [OwnerDashboardController::class, 'dismissWelcomeTutorial'])->name('welcome-tutorial.dismiss');
    Route::resource('properties', PropertyController::class);
    Route::resource('housekeepers', OwnerHousekeeperController::class);
    Route::resource('tasks', OwnerTaskController::class);
    
    // Checklist routes (called Assignments for owners)
    Route::get('/checklists', [OwnerChecklistController::class, 'index'])->name('checklists.index');
    Route::post('/checklists', [OwnerChecklistController::class, 'store'])->name('checklists.store');
    Route::get('/checklists/{checklist}', [OwnerChecklistController::class, 'show'])->name('checklists.show');
    Route::delete('/checklists/{checklist}', [OwnerChecklistController::class, 'destroy'])->name('checklists.destroy');
    
    // Room management (nested under properties)
    Route::get('/properties/{property}/rooms', [OwnerRoomController::class, 'index'])->name('rooms.index');
    Route::get('/properties/{property}/rooms/create', [OwnerRoomController::class, 'create'])->name('rooms.create');
    Route::post('/properties/{property}/rooms', [OwnerRoomController::class, 'store'])->name('rooms.store');
    Route::get('/properties/{property}/rooms/{room}/edit', [OwnerRoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/properties/{property}/rooms/{room}', [OwnerRoomController::class, 'update'])->name('rooms.update');
    Route::delete('/properties/{property}/rooms/{room}', [OwnerRoomController::class, 'destroy'])->name('rooms.destroy');
    
    // Task assignment to rooms
    Route::post('/properties/{property}/rooms/{room}/tasks', [OwnerRoomController::class, 'attachTask'])->name('rooms.attach-task');
    Route::delete('/properties/{property}/rooms/{room}/tasks/{task}', [OwnerRoomController::class, 'detachTask'])->name('rooms.detach-task');
    
    // Bulk add default rooms
    Route::post('/properties/{property}/rooms/add-defaults', [OwnerRoomController::class, 'addDefaults'])->name('rooms.add-defaults');
    
    // Calendar and assignment routes
    Route::get('/calendar', [OwnerCalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [OwnerCalendarController::class, 'getEvents'])->name('calendar.events');
    Route::post('/calendar/assign', [OwnerCalendarController::class, 'store'])->name('calendar.assign');
    Route::get('/calendar/checklist/{checklist}', [OwnerCalendarController::class, 'show'])->name('calendar.show');
    Route::delete('/calendar/checklist/{checklist}', [OwnerCalendarController::class, 'destroy'])->name('calendar.destroy');
});

// Housekeeper Routes
Route::middleware(['auth', 'role:housekeeper'])->prefix('housekeeper')->name('housekeeper.')->group(function () {
    Route::get('/dashboard', [HousekeeperDashboardController::class, 'index'])->name('dashboard');
    
    // Calendar routes
    Route::get('/calendar', [HousekeeperCalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [HousekeeperCalendarController::class, 'getEvents'])->name('calendar.events');
    
    // Checklist routes
    Route::get('/checklist/{checklist}', [ChecklistController::class, 'show'])->name('checklist.show');
    Route::post('/checklist/{checklist}/start', [ChecklistController::class, 'start'])->name('checklist.start');
    Route::post('/checklist/{checklist}/item/{item}/complete', [ChecklistController::class, 'completeItem'])->name('checklist.item.complete');
    Route::post('/checklist/{checklist}/room/complete', [ChecklistController::class, 'completeRoom'])->name('checklist.room.complete');
    Route::post('/checklist/{checklist}/inventory/{item}/complete', [ChecklistController::class, 'completeInventoryItem'])->name('checklist.inventory.item.complete');
    Route::post('/checklist/{checklist}/inventory/complete', [ChecklistController::class, 'completeInventory'])->name('checklist.inventory.complete');
    Route::post('/checklist/{checklist}/photo', [ChecklistController::class, 'uploadPhoto'])->name('checklist.photo.upload');
    Route::get('/checklist/{checklist}/summary', [ChecklistController::class, 'summary'])->name('checklist.summary');
    Route::post('/checklist/{checklist}/complete', [ChecklistController::class, 'complete'])->name('checklist.complete');
});

