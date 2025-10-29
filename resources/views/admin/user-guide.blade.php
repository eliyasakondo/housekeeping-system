@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="bi bi-book-fill text-primary me-2"></i>
                        Admin User Guide
                    </h1>
                    <p class="text-muted mb-0">Complete guide to managing your housekeeping system</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Table of Contents -->
        <div class="col-lg-3 mb-4">
            <div class="card sticky-top" style="top: 100px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Contents
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#overview" class="list-group-item list-group-item-action">
                        <i class="bi bi-info-circle me-2"></i>System Overview
                    </a>
                    <a href="#dashboard" class="list-group-item list-group-item-action">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    <a href="#users" class="list-group-item list-group-item-action">
                        <i class="bi bi-people me-2"></i>Managing Users
                    </a>
                    <a href="#properties" class="list-group-item list-group-item-action">
                        <i class="bi bi-building me-2"></i>Managing Properties
                    </a>
                    <a href="#rooms" class="list-group-item list-group-item-action">
                        <i class="bi bi-door-open me-2"></i>Default Rooms
                    </a>
                    <a href="#tasks" class="list-group-item list-group-item-action">
                        <i class="bi bi-list-check me-2"></i>Managing Tasks
                    </a>
                    <a href="#calendar" class="list-group-item list-group-item-action">
                        <i class="bi bi-calendar-range me-2"></i>Calendar & Assignments
                    </a>
                    <a href="#checklists" class="list-group-item list-group-item-action">
                        <i class="bi bi-clipboard-check me-2"></i>Checklists
                    </a>
                    <a href="#settings" class="list-group-item list-group-item-action">
                        <i class="bi bi-gear me-2"></i>System Settings
                    </a>
                    <a href="#faq" class="list-group-item list-group-item-action">
                        <i class="bi bi-question-circle me-2"></i>FAQ
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- System Overview -->
            <div id="overview" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        System Overview
                    </h4>
                </div>
                <div class="card-body">
                    <h5 class="text-primary">Welcome, Administrator!</h5>
                    <p class="lead">As an admin, you have full control over the entire housekeeping management system.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Your Capabilities
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Create and manage all user accounts</li>
                                        <li>Full access to all properties system-wide</li>
                                        <li>Manage rooms and tasks for any property</li>
                                        <li>Create and assign housekeeping tasks</li>
                                        <li>View and manage all checklists</li>
                                        <li>Configure system-wide settings</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary">
                                        <i class="bi bi-diagram-3 me-2"></i>
                                        User Roles
                                    </h6>
                                    <ul class="mb-0">
                                        <li><strong>Admin:</strong> Full system access</li>
                                        <li><strong>Owner:</strong> Manages their properties</li>
                                        <li><strong>Housekeeper:</strong> Completes assigned tasks</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Quick Tip:</strong> Use the sidebar navigation to access different sections. Featured actions have a glowing effect for quick access.
                    </div>
                </div>
            </div>

            <!-- Dashboard -->
            <div id="dashboard" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </h4>
                </div>
                <div class="card-body">
                    <p>The dashboard provides an at-a-glance overview of your entire system.</p>
                    
                    <h6 class="text-primary mt-4">Key Metrics</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li><strong>Total Properties:</strong> Number of properties in the system</li>
                                <li><strong>Active Housekeepers:</strong> Number of housekeepers currently working</li>
                                <li><strong>Pending Checklists:</strong> Tasks waiting to be started</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li><strong>In Progress:</strong> Tasks currently being worked on</li>
                                <li><strong>Completed Today:</strong> Tasks finished today</li>
                                <li><strong>System Health:</strong> Overall system status</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-success mt-3">
                        <i class="bi bi-graph-up me-2"></i>
                        <strong>Dashboard Tip:</strong> Click on any metric card to view detailed information about that category.
                    </div>
                </div>
            </div>

            <!-- Managing Users -->
            <div id="users" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-people me-2"></i>
                        Managing Users
                    </h4>
                </div>
                <div class="card-body">
                    <p>Control all user accounts in the system. You can create, edit, and delete users with different roles.</p>
                    
                    <h6 class="text-primary mt-4">Creating a New User</h6>
                    <ol>
                        <li>Navigate to <strong>Users</strong> from the sidebar</li>
                        <li>Click the <span class="badge bg-success">+ Add User</span> button</li>
                        <li>Fill in the required information:
                            <ul>
                                <li><strong>Name:</strong> Full name of the user</li>
                                <li><strong>Email:</strong> Valid email address (used for login)</li>
                                <li><strong>Password:</strong> Secure password (min. 8 characters)</li>
                                <li><strong>Role:</strong> Select Admin, Owner, or Housekeeper</li>
                                <li><strong>Phone:</strong> Contact number (optional)</li>
                            </ul>
                        </li>
                        <li>Click <span class="badge bg-primary">Create User</span></li>
                    </ol>

                    <h6 class="text-primary mt-4">Editing Users</h6>
                    <ol>
                        <li>Find the user in the users list</li>
                        <li>Click the <button class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</button> button</li>
                        <li>Update the necessary information</li>
                        <li>Click <span class="badge bg-primary">Update User</span> to save changes</li>
                    </ol>

                    <h6 class="text-primary mt-4">Deleting Users</h6>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> Deleting a user is permanent. All their data will be removed.
                    </div>
                    <ol>
                        <li>Click the <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button> button</li>
                        <li>Confirm the deletion in the popup dialog</li>
                    </ol>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-key me-2"></i>
                        <strong>Security Note:</strong> Users login with their email and password. Password requirements: minimum 8 characters.
                    </div>
                </div>
            </div>

            <!-- Managing Properties -->
            <div id="properties" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        Managing Properties
                    </h4>
                </div>
                <div class="card-body">
                    <p>As an admin, you can view and manage ALL properties in the system, regardless of owner.</p>
                    
                    <h6 class="text-primary mt-4">Creating a Property</h6>
                    <ol>
                        <li>Navigate to <strong>Properties</strong> from the sidebar</li>
                        <li>Click <span class="badge bg-success">+ Add Property</span></li>
                        <li>Fill in property details:
                            <ul>
                                <li><strong>Owner:</strong> Select the property owner from dropdown</li>
                                <li><strong>Property Name:</strong> Descriptive name</li>
                                <li><strong>Address:</strong> Full address</li>
                                <li><strong>Beds & Baths:</strong> Number of bedrooms and bathrooms</li>
                                <li><strong>GPS Coordinates:</strong> Latitude and Longitude
                                    <div class="alert alert-warning mt-2 mb-0">
                                        <i class="bi bi-geo-alt me-2"></i>
                                        <strong>GPS Required:</strong> If you want housekeepers to maintain GPS tracking, you MUST provide latitude and longitude values.
                                        <br><small class="text-muted">Example: Latitude: 23.8103, Longitude: 90.4125</small>
                                    </div>
                                </li>
                                <li><strong>Description:</strong> Additional notes (optional)</li>
                            </ul>
                        </li>
                        <li>Click <span class="badge bg-primary">Create Property</span></li>
                    </ol>

                    <h6 class="text-primary mt-4">Managing Property Rooms</h6>
                    <p>When viewing a property's details, you can manage its rooms:</p>
                    <ol>
                        <li>Click on a property to view details</li>
                        <li>In the <strong>Rooms & Tasks</strong> section:
                            <ul>
                                <li><strong>Add Custom Room:</strong> Click the green button to manually add a room</li>
                                <li><strong>Quick Add Default Rooms:</strong> Click to add all 9 standard rooms at once (Bedroom, Bathroom, Kitchen, Living Room, Dining Room, Laundry Room, Garage, Hallway, Storage)</li>
                                <li><strong>Delete Room:</strong> Click the red trash icon on any room card</li>
                            </ul>
                        </li>
                    </ol>

                    <h6 class="text-primary mt-4">Assigning Tasks to Rooms</h6>
                    <p>You can assign specific cleaning tasks to each room:</p>
                    <ol>
                        <li>On the property details page, find the room card</li>
                        <li>Use the <strong>Assign Task</strong> dropdown to select a task</li>
                        <li>Click the <button class="btn btn-sm btn-success">Assign</button> button</li>
                        <li>To remove a task, click the <button class="btn btn-sm btn-danger btn-sm">Remove</button> button next to the task</li>
                    </ol>

                    <div class="alert alert-success mt-3">
                        <i class="bi bi-lightning me-2"></i>
                        <strong>Pro Tip:</strong> Use "Quick Add Default Rooms" to save time when setting up new properties. You can customize rooms afterward.
                    </div>
                </div>
            </div>

            <!-- Default Rooms -->
            <div id="rooms" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-door-open me-2"></i>
                        Default Rooms
                    </h4>
                </div>
                <div class="card-body">
                    <p>Manage the template rooms that can be quickly added to any property.</p>
                    
                    <h6 class="text-primary mt-4">Creating Default Rooms</h6>
                    <ol>
                        <li>Navigate to <strong>Default Rooms</strong> from the sidebar</li>
                        <li>Click <span class="badge bg-success">+ Add Room</span></li>
                        <li>Enter room name (e.g., "Master Bedroom", "Guest Bathroom")</li>
                        <li>Optionally add a description</li>
                        <li>Click <span class="badge bg-primary">Create Room</span></li>
                    </ol>

                    <h6 class="text-primary mt-4">Standard Default Rooms</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>Bedroom</li>
                                <li>Bathroom</li>
                                <li>Kitchen</li>
                                <li>Living Room</li>
                                <li>Dining Room</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Laundry Room</li>
                                <li>Garage</li>
                                <li>Hallway</li>
                                <li>Storage</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-copy me-2"></i>
                        <strong>Note:</strong> Default rooms are templates. When added to a property, they become property-specific and can be customized independently.
                    </div>
                </div>
            </div>

            <!-- Managing Tasks -->
            <div id="tasks" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-list-check me-2"></i>
                        Managing Tasks
                    </h4>
                </div>
                <div class="card-body">
                    <p>Define cleaning tasks that housekeepers need to complete.</p>
                    
                    <h6 class="text-primary mt-4">Creating Tasks</h6>
                    <ol>
                        <li>Navigate to <strong>Tasks</strong> from the sidebar</li>
                        <li>Click <span class="badge bg-success">+ Add Task</span></li>
                        <li>Fill in task details:
                            <ul>
                                <li><strong>Task Name:</strong> Clear, descriptive name (e.g., "Clean Windows")</li>
                                <li><strong>Description:</strong> Detailed instructions for the task</li>
                                <li><strong>Room Type:</strong> Which room type this task applies to (optional)</li>
                                <li><strong>Is Default:</strong> Check if this task should be available system-wide</li>
                            </ul>
                        </li>
                        <li>Click <span class="badge bg-primary">Create Task</span></li>
                    </ol>

                    <h6 class="text-primary mt-4">Default vs Custom Tasks</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-success">
                                        <i class="bi bi-globe me-2"></i>
                                        Default Tasks
                                    </h6>
                                    <ul class="small mb-0">
                                        <li>Available to all properties</li>
                                        <li>Standardized cleaning tasks</li>
                                        <li>Cannot be deleted by owners</li>
                                        <li>System-wide consistency</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-primary">
                                        <i class="bi bi-person me-2"></i>
                                        Custom Tasks
                                    </h6>
                                    <ul class="small mb-0">
                                        <li>Created by owners for their properties</li>
                                        <li>Property-specific requirements</li>
                                        <li>Flexible and customizable</li>
                                        <li>Owner can edit/delete</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary mt-4">Example Tasks</h6>
                    <ul>
                        <li>Vacuum floors</li>
                        <li>Dust surfaces</li>
                        <li>Clean windows</li>
                        <li>Change bed linens</li>
                        <li>Sanitize bathroom fixtures</li>
                        <li>Empty trash bins</li>
                        <li>Mop floors</li>
                        <li>Clean mirrors</li>
                    </ul>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-star me-2"></i>
                        <strong>Best Practice:</strong> Create clear, actionable tasks with specific instructions. This helps housekeepers complete work consistently.
                    </div>
                </div>
            </div>

            <!-- Calendar & Assignments -->
            <div id="calendar" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-range me-2"></i>
                        Calendar & Assignments
                    </h4>
                </div>
                <div class="card-body">
                    <p>Schedule and manage housekeeping assignments across all properties.</p>
                    
                    <h6 class="text-primary mt-4">Creating Assignments (Method 1: Calendar)</h6>
                    <ol>
                        <li>Navigate to <strong>Calendar</strong> from the sidebar</li>
                        <li>Click on any date or time slot on the calendar</li>
                        <li>Fill in the assignment form:
                            <ul>
                                <li><strong>Property:</strong> Select the property to be cleaned</li>
                                <li><strong>Housekeeper:</strong> Choose who will do the work</li>
                                <li><strong>Date:</strong> Schedule date</li>
                                <li><strong>Time:</strong> Start time (optional)</li>
                            </ul>
                        </li>
                        <li>Click <span class="badge bg-success">Create Assignment</span></li>
                    </ol>

                    <h6 class="text-primary mt-4">Creating Assignments (Method 2: Quick Assign)</h6>
                    <ol>
                        <li>Click <strong>Assign Housekeeper</strong> in the sidebar (featured action)</li>
                        <li>This provides a quick form without the calendar view</li>
                        <li>Fill in property, housekeeper, date, and time</li>
                        <li>Click <span class="badge bg-success">Create Assignment</span></li>
                    </ol>

                    <h6 class="text-primary mt-4">Managing Assignments</h6>
                    <ul>
                        <li><strong>View Details:</strong> Click on any calendar event to see full details</li>
                        <li><strong>Edit Assignment:</strong> Click on an event and modify the details</li>
                        <li><strong>Delete Assignment:</strong> Click the delete button on the event details</li>
                        <li><strong>Color Coding:</strong> Events are color-coded by status:
                            <ul>
                                <li><span class="badge bg-warning text-dark">Yellow</span> - Pending</li>
                                <li><span class="badge bg-info">Blue</span> - In Progress</li>
                                <li><span class="badge bg-success">Green</span> - Completed</li>
                            </ul>
                        </li>
                    </ul>

                    <h6 class="text-primary mt-4">Calendar Views</h6>
                    <p>Switch between different calendar views using the buttons at the top:</p>
                    <ul>
                        <li><strong>Month:</strong> See the entire month at a glance</li>
                        <li><strong>Week:</strong> View a detailed weekly schedule</li>
                        <li><strong>Day:</strong> Focus on a single day's assignments</li>
                    </ul>

                    <div class="alert alert-success mt-3">
                        <i class="bi bi-lightning-fill me-2"></i>
                        <strong>Quick Tip:</strong> Use the "Assign Housekeeper" quick action for faster assignment creation without navigating to the calendar.
                    </div>
                </div>
            </div>

            <!-- Checklists -->
            <div id="checklists" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-clipboard-check me-2"></i>
                        Checklists
                    </h4>
                </div>
                <div class="card-body">
                    <p>Monitor all housekeeping checklists across the entire system.</p>
                    
                    <h6 class="text-primary mt-4">Understanding Checklists</h6>
                    <p>When you create an assignment, a checklist is automatically generated for the housekeeper. This checklist contains all tasks assigned to the property's rooms.</p>

                    <h6 class="text-primary mt-4">Checklist Status</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-warning bg-opacity-10 border-warning mb-3">
                                <div class="card-body">
                                    <h6 class="text-warning">
                                        <i class="bi bi-clock me-2"></i>
                                        Pending
                                    </h6>
                                    <p class="small mb-0">Assignment created, housekeeper hasn't started yet</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info bg-opacity-10 border-info mb-3">
                                <div class="card-body">
                                    <h6 class="text-info">
                                        <i class="bi bi-hourglass-split me-2"></i>
                                        In Progress
                                    </h6>
                                    <p class="small mb-0">Housekeeper is actively working on tasks</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success bg-opacity-10 border-success mb-3">
                                <div class="card-body">
                                    <h6 class="text-success">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Completed
                                    </h6>
                                    <p class="small mb-0">All tasks finished with photos uploaded</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary mt-4">Viewing Checklists</h6>
                    <ol>
                        <li>Navigate to <strong>Checklists</strong> from the sidebar</li>
                        <li>Use filters to find specific checklists:
                            <ul>
                                <li>Filter by property</li>
                                <li>Filter by housekeeper</li>
                                <li>Filter by status</li>
                                <li>Filter by date range</li>
                            </ul>
                        </li>
                        <li>Click on a checklist to view full details</li>
                    </ol>

                    <h6 class="text-primary mt-4">Checklist Details</h6>
                    <p>When viewing a checklist, you can see:</p>
                    <ul>
                        <li>Property information</li>
                        <li>Assigned housekeeper</li>
                        <li>All rooms and their tasks</li>
                        <li>Task completion status (checkmarks)</li>
                        <li>Photos uploaded by housekeeper (with timestamps)</li>
                        <li>GPS location tracking (if enabled)</li>
                        <li>Start and completion times</li>
                    </ul>

                    <h6 class="text-primary mt-4">Photo Verification</h6>
                    <div class="alert alert-info">
                        <i class="bi bi-camera me-2"></i>
                        <strong>Important:</strong> Each room requires photo uploads with timestamp overlays. The minimum is 8 photos per checklist, but owners can configure different requirements. Timestamps are automatically added and cannot be edited.
                    </div>

                    <h6 class="text-primary mt-4">GPS Tracking</h6>
                    <p>If the property has GPS coordinates configured:</p>
                    <ul>
                        <li>Housekeepers must be within 100 meters to start work</li>
                        <li>Location is verified when starting and completing tasks</li>
                        <li>You can view the housekeeper's location on the map</li>
                    </ul>

                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> You can delete checklists, but this action is permanent and will remove all associated data including photos.
                    </div>
                </div>
            </div>

            <!-- System Settings -->
            <div id="settings" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        System Settings
                    </h4>
                </div>
                <div class="card-body">
                    <p>Configure system-wide settings and preferences.</p>
                    
                    <h6 class="text-primary mt-4">Available Settings</h6>
                    <ul>
                        <li><strong>Minimum Photos Required:</strong> Set the minimum number of photos housekeepers must upload per checklist (default: 8)</li>
                        <li><strong>GPS Verification Radius:</strong> Distance in meters for GPS verification (default: 100m)</li>
                        <li><strong>System Timezone:</strong> Configure the timezone for all date/time displays</li>
                        <li><strong>Email Notifications:</strong> Enable/disable email alerts for key events</li>
                    </ul>

                    <h6 class="text-primary mt-4">Changing Settings</h6>
                    <ol>
                        <li>Navigate to <strong>Settings</strong> from the sidebar</li>
                        <li>Modify the setting value</li>
                        <li>Click <span class="badge bg-primary">Save Settings</span></li>
                        <li>A success notification will confirm the change</li>
                    </ol>

                    <h6 class="text-primary mt-4">Resetting to Defaults</h6>
                    <p>If needed, you can reset all settings to their default values:</p>
                    <ol>
                        <li>Click the <button class="btn btn-sm btn-warning">Reset to Defaults</button> button</li>
                        <li>Confirm the action in the popup</li>
                        <li>All settings will be restored to original values</li>
                    </ol>

                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-shield-exclamation me-2"></i>
                        <strong>Important:</strong> Settings changes affect the entire system and all users. Make changes carefully and test after modifications.
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div id="faq" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-question-circle me-2"></i>
                        Frequently Asked Questions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <!-- Question 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="bi bi-question-circle me-2"></i>
                                    How do I reset a user's password?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Go to Users, click Edit on the user, and enter a new password in the password field. Leave it blank to keep the existing password unchanged.
                                </div>
                            </div>
                        </div>

                        <!-- Question 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Can I assign multiple housekeepers to one property?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes! You can create multiple assignments for the same property on different dates or times. Each assignment creates a separate checklist.
                                </div>
                            </div>
                        </div>

                        <!-- Question 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="bi bi-question-circle me-2"></i>
                                    What happens if GPS coordinates aren't provided?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    GPS verification is optional. If coordinates aren't provided, housekeepers can start work from any location. However, for accountability, GPS coordinates are highly recommended.
                                </div>
                            </div>
                        </div>

                        <!-- Question 4 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="bi bi-question-circle me-2"></i>
                                    How do timestamp overlays work on photos?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    When housekeepers upload photos, the system automatically adds a timestamp overlay showing the exact date and time. This timestamp cannot be edited or removed, ensuring photo authenticity.
                                </div>
                            </div>
                        </div>

                        <!-- Question 5 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Can I modify a checklist after it's created?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    No, checklists cannot be edited once created. However, you can delete and recreate an assignment if needed. This maintains data integrity and audit trails.
                                </div>
                            </div>
                        </div>

                        <!-- Question 6 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    <i class="bi bi-question-circle me-2"></i>
                                    What's the difference between Default Rooms and property rooms?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Default Rooms are templates you manage in the system. When you "Quick Add Default Rooms" to a property, these templates are copied to that property and become property-specific rooms that can be customized independently.
                                </div>
                            </div>
                        </div>

                        <!-- Question 7 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    <i class="bi bi-question-circle me-2"></i>
                                    How do I know if a housekeeper is currently working?
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Check the Dashboard for "Active Housekeepers" count, or view the Calendar where in-progress assignments are shown in blue. You can also filter the Checklists page by "In Progress" status.
                                </div>
                            </div>
                        </div>

                        <!-- Question 8 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Can owners see all properties in the system?
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    No, owners can only see and manage their own properties. As an admin, you have visibility and control over all properties system-wide.
                                </div>
                            </div>
                        </div>

                        <!-- Question 9 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                    <i class="bi bi-question-circle me-2"></i>
                                    What should I do if a housekeeper reports a problem?
                                </button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Check the checklist details to see their progress and any notes they've added. You can contact the property owner to address issues, or reassign the task to another housekeeper if needed.
                                </div>
                            </div>
                        </div>

                        <!-- Question 10 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                    <i class="bi bi-question-circle me-2"></i>
                                    How do I manage tasks for a specific property?
                                </button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Go to Properties, click on the property, and you'll see the Rooms & Tasks section. Each room card has an "Assign Task" dropdown where you can add tasks from the available list. Both default tasks and owner-created tasks will appear in the dropdown.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Reference Card -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-lightning-fill me-2"></i>
                        Quick Reference
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Most Common Tasks</h6>
                            <ol>
                                <li>Create new user account</li>
                                <li>Add property for an owner</li>
                                <li>Assign housekeeper to property</li>
                                <li>Monitor checklist completion</li>
                                <li>Review photos and GPS data</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Keyboard Shortcuts</h6>
                            <ul>
                                <li><kbd>Alt + D</kbd> - Go to Dashboard</li>
                                <li><kbd>Alt + P</kbd> - View Properties</li>
                                <li><kbd>Alt + C</kbd> - Open Calendar</li>
                                <li><kbd>Alt + U</kbd> - Manage Users</li>
                            </ul>
                            <p class="small text-muted mb-0"><em>Note: Shortcuts may vary by browser</em></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help & Support -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-headset me-2"></i>
                        Need More Help?
                    </h4>
                </div>
                <div class="card-body">
                    <p>If you need additional assistance or have questions not covered in this guide:</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <i class="bi bi-envelope-fill text-info" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Email Support</h6>
                                <p class="small text-muted">support@housekeeping.com</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <i class="bi bi-telephone-fill text-info" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Phone Support</h6>
                                <p class="small text-muted">1-800-CLEAN-24</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <i class="bi bi-chat-dots-fill text-info" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Live Chat</h6>
                                <p class="small text-muted">Available 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Sticky sidebar scroll */
    .sticky-top {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }
    
    /* Custom scrollbar for sidebar */
    .sticky-top::-webkit-scrollbar {
        width: 6px;
    }
    
    .sticky-top::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .sticky-top::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .sticky-top::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Highlight target sections */
    .card[id]:target {
        animation: highlight 1s ease-in-out;
    }
    
    @keyframes highlight {
        0% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
        }
        50% {
            box-shadow: 0 0 0 15px rgba(13, 110, 253, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
        }
    }
    
    /* List group hover effect */
    .list-group-item-action:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #0d6efd;
        padding-left: calc(1rem - 3px);
    }
    
    /* Accordion custom styling */
    .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0d6efd;
    }
    
    /* Badge styles */
    kbd {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.2rem 0.4rem;
        font-size: 0.875rem;
        color: #212529;
    }
</style>

<script>
    // Smooth scroll with offset for fixed header
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 100;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Highlight active section in sidebar
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('.card[id]');
        const scrollPos = window.scrollY + 150;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                document.querySelectorAll('.list-group-item-action').forEach(link => {
                    link.classList.remove('active');
                });
                const activeLink = document.querySelector(`a[href="#${sectionId}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        });
    });
</script>
@endsection
