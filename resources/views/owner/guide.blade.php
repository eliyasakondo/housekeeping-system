@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-book-fill me-2"></i>Property Owner User Guide</h2>
                <p class="text-muted mb-0">Complete step-by-step instructions for managing your properties and housekeepers</p>
            </div>

            <div class="row">
                <!-- Table of Contents -->
                <div class="col-lg-3">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Quick Navigation</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="#getting-started" class="list-group-item list-group-item-action">
                                    <i class="bi bi-play-circle me-2"></i>Getting Started
                                </a>
                                <a href="#properties" class="list-group-item list-group-item-action">
                                    <i class="bi bi-building me-2"></i>Managing Properties
                                </a>
                                <a href="#rooms" class="list-group-item list-group-item-action">
                                    <i class="bi bi-door-open me-2"></i>Creating Rooms
                                </a>
                                <a href="#tasks" class="list-group-item list-group-item-action">
                                    <i class="bi bi-list-check me-2"></i>Managing Tasks
                                </a>
                                <a href="#housekeepers" class="list-group-item list-group-item-action">
                                    <i class="bi bi-person-badge me-2"></i>Adding Housekeepers
                                </a>
                                <a href="#assignments" class="list-group-item list-group-item-action">
                                    <i class="bi bi-calendar-check me-2"></i>Creating Assignments
                                </a>
                                <a href="#scheduling" class="list-group-item list-group-item-action">
                                    <i class="bi bi-calendar-event me-2"></i>Scheduling Cleanings
                                </a>
                                <a href="#monitoring" class="list-group-item list-group-item-action">
                                    <i class="bi bi-clipboard-check me-2"></i>Monitoring Progress
                                </a>
                                <a href="#troubleshooting" class="list-group-item list-group-item-action">
                                    <i class="bi bi-tools me-2"></i>Troubleshooting
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guide Content -->
                <div class="col-lg-9">
                    
                    <!-- Getting Started -->
                    <div id="getting-started" class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-play-circle me-2"></i>Getting Started</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-primary mb-3">Welcome to Your Dashboard!</h5>
                            <p>As a property owner, you have complete control over managing your properties, housekeepers, and cleaning schedules. Follow this guide to set up your system step-by-step.</p>
                            
                            <div class="alert alert-info">
                                <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Setup Checklist</h6>
                                <p class="mb-2">Complete these steps in order:</p>
                                <ol class="mb-0">
                                    <li>Add your properties</li>
                                    <li>Create rooms for each property</li>
                                    <li>Define tasks for each room</li>
                                    <li>Add housekeepers to your account</li>
                                    <li>Create cleaning assignments</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Managing Properties -->
                    <div id="properties" class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0"><i class="bi bi-building me-2"></i>1. Managing Properties</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-success mb-3">How to Add a New Property</h5>
                            
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Navigate to Properties</h6>
                                    <p>Click on <strong>"Properties"</strong> in the sidebar menu.</p>
                                    <a href="{{ route('owner.properties.index') }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-building me-1"></i>Go to Properties
                                    </a>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Click "Add Property"</h6>
                                    <p>Click the green <strong>"Add Property"</strong> button at the top of the page.</p>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Fill in Property Details</h6>
                                    <p>Enter the following information:</p>
                                    <ul>
                                        <li><strong>Property Name:</strong> A unique name (e.g., "Beachfront Villa A1")</li>
                                        <li><strong>Address:</strong> Full street address</li>
                                        <li><strong>GPS Coordinates:</strong> Latitude and Longitude (for location verification)</li>
                                    </ul>
                                    <div class="alert alert-warning">
                                        <small><i class="bi bi-exclamation-triangle me-1"></i><strong>Important:</strong> GPS coordinates are required for housekeepers to check in when they arrive at the property.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="step-box">
                                <span class="step-number">4</span>
                                <div class="step-content">
                                    <h6>Save Your Property</h6>
                                    <p>Click <strong>"Create Property"</strong> to save. You'll be redirected to the properties list.</p>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <h6 class="alert-heading"><i class="bi bi-lightbulb me-2"></i>Pro Tip</h6>
                                <p class="mb-0">You can find GPS coordinates by searching your property address on Google Maps, then right-clicking the location and selecting the coordinates.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Creating Rooms -->
                    <div id="rooms" class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0"><i class="bi bi-door-open me-2"></i>2. Creating Rooms</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-info mb-3">How to Add Rooms to Your Property</h5>
                            
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Go to Property Details</h6>
                                    <p>From the Properties page, click <strong>"View"</strong> on any property.</p>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Use Quick Add or Manual Entry</h6>
                                    <p>You have two options:</p>
                                    <ul>
                                        <li><strong>Quick Add Default Rooms:</strong> Click the blue button to instantly add common rooms (Living Room, Kitchen, Bedroom, Bathroom, etc.)</li>
                                        <li><strong>Add Custom Room:</strong> Click "Add Room" to create a room with a custom name</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Configure Room Settings</h6>
                                    <p>For each room, you can set:</p>
                                    <ul>
                                        <li><strong>Room Name:</strong> E.g., "Master Bedroom", "Pool Area"</li>
                                        <li><strong>Minimum Photos:</strong> How many photos housekeepers must upload (default: 8)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="alert alert-success mt-4">
                                <h6 class="alert-heading"><i class="bi bi-check-circle me-2"></i>Good to Know</h6>
                                <p class="mb-0">The "Quick Add Default Rooms" button is always available, even after you've added custom rooms. It will skip any rooms that already exist.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Managing Tasks -->
                    <div id="tasks" class="card shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0"><i class="bi bi-list-check me-2"></i>3. Managing Tasks</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-warning mb-3">How to Create and Assign Tasks</h5>
                            
                            <h6 class="fw-bold mt-4 mb-3">Creating Global Tasks</h6>
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Go to Tasks Menu</h6>
                                    <p>Click <strong>"Tasks"</strong> in the sidebar.</p>
                                    <a href="{{ route('owner.tasks.index') }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-list-check me-1"></i>Go to Tasks
                                    </a>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Click "Add Task"</h6>
                                    <p>Enter a task name (e.g., "Vacuum floors", "Change bed sheets", "Clean windows").</p>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Add Description (Optional)</h6>
                                    <p>Provide detailed instructions for how the task should be completed.</p>
                                </div>
                            </div>

                            <h6 class="fw-bold mt-4 mb-3">Assigning Tasks to Rooms</h6>
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Go to Property Rooms</h6>
                                    <p>View any property, then scroll to the Rooms section.</p>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Assign Tasks to Each Room</h6>
                                    <p>For each room, select which tasks apply (e.g., "Kitchen" might have "Clean countertops", "Mop floor", etc.).</p>
                                </div>
                            </div>

                            <div class="alert alert-danger mt-4">
                                <h6 class="alert-heading"><i class="bi bi-exclamation-octagon me-2"></i>Critical Requirement</h6>
                                <p class="mb-0">Properties must have at least one room with assigned tasks before you can create cleaning assignments. The system will prevent assignments to incomplete properties.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Adding Housekeepers -->
                    <div id="housekeepers" class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-person-badge me-2"></i>4. Adding Housekeepers</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-primary mb-3">How to Add Housekeepers to Your Account</h5>
                            
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Navigate to Housekeepers</h6>
                                    <p>Click <strong>"Housekeepers"</strong> in the sidebar menu.</p>
                                    <a href="{{ route('owner.housekeepers.index') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-person-badge me-1"></i>Go to Housekeepers
                                    </a>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Click "Add Housekeeper"</h6>
                                    <p>Fill in the housekeeper's information:</p>
                                    <ul>
                                        <li><strong>Name:</strong> Full name</li>
                                        <li><strong>Email:</strong> Unique email address for login</li>
                                        <li><strong>Password:</strong> Initial login password (they can change it later)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="step-box">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Housekeeper Receives Access</h6>
                                    <p>The housekeeper can now log in with their email and password to view their assigned checklists.</p>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <h6 class="alert-heading"><i class="bi bi-shield-check me-2"></i>Privacy Note</h6>
                                <p class="mb-0">Housekeepers can only see properties and assignments that you specifically assign to them. They cannot view other owners' data.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Creating Assignments -->
                    <div id="assignments" class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>5. Creating Assignments</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-success mb-3">How to Assign Housekeepers to Properties</h5>
                            
                            <div class="alert alert-info mb-4">
                                <p class="mb-0"><strong>Two Ways to Create Assignments:</strong></p>
                                <ul class="mb-0 mt-2">
                                    <li><strong>Quick Assign:</strong> Use the "Assign Housekeeper" page for a simple form</li>
                                    <li><strong>Calendar View:</strong> Use the "Schedule Cleaning" calendar for visual scheduling</li>
                                </ul>
                            </div>

                            <h6 class="fw-bold mt-4 mb-3">Method 1: Quick Assign (Recommended for Beginners)</h6>
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Go to Assign Housekeeper</h6>
                                    <p>Click <strong>"Assign Housekeeper"</strong> in the sidebar.</p>
                                    <a href="{{ route('owner.assign-housekeeper') }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-person-plus me-1"></i>Go to Quick Assign
                                    </a>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Fill in Assignment Details</h6>
                                    <ul>
                                        <li>Select a property (only ready properties are available)</li>
                                        <li>Select a housekeeper</li>
                                        <li>Choose a date</li>
                                        <li>Optionally set a specific time</li>
                                        <li>Add notes if needed</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="step-box">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Submit Assignment</h6>
                                    <p>Click <strong>"Create Assignment"</strong>. The housekeeper will see it in their dashboard immediately.</p>
                                </div>
                            </div>

                            <h6 class="fw-bold mt-5 mb-3">Method 2: Calendar View (Visual Scheduling)</h6>
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>Go to Schedule Cleaning</h6>
                                    <p>Click <strong>"Schedule Cleaning"</strong> in the sidebar to open the calendar.</p>
                                    <a href="{{ route('owner.calendar') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-calendar-event me-1"></i>Go to Calendar
                                    </a>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>Click on a Date</h6>
                                    <p>Click any date on the calendar to open the assignment form.</p>
                                </div>
                            </div>

                            <div class="step-box">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Create the Assignment</h6>
                                    <p>Fill in the same details as Quick Assign and submit. The assignment will appear on the calendar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scheduling -->
                    <div id="scheduling" class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0"><i class="bi bi-calendar-event me-2"></i>6. Scheduling & Calendar</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-info mb-3">Understanding the Calendar View</h5>
                            
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center mb-2">
                                            <div style="width: 20px; height: 20px; background: #6c757d; border-radius: 4px;" class="me-2"></div>
                                            <strong>Gray Events</strong>
                                        </div>
                                        <p class="small mb-0">Pending assignments (not started yet)</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center mb-2">
                                            <div style="width: 20px; height: 20px; background: #0dcaf0; border-radius: 4px;" class="me-2"></div>
                                            <strong>Cyan Events</strong>
                                        </div>
                                        <p class="small mb-0">In progress (housekeeper is working)</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center mb-2">
                                            <div style="width: 20px; height: 20px; background: #198754; border-radius: 4px;" class="me-2"></div>
                                            <strong>Green Events</strong>
                                        </div>
                                        <p class="small mb-0">Completed successfully</p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Calendar Features</h6>
                                <ul class="mb-0">
                                    <li>Click any event to view full details</li>
                                    <li>You can only delete pending assignments (not started ones)</li>
                                    <li>Time is displayed if you set a specific time, otherwise shows as all-day</li>
                                    <li>Switch between month, week, and day views using calendar controls</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Monitoring Progress -->
                    <div id="monitoring" class="card shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>7. Monitoring Progress</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-warning mb-3">How to Track Housekeeper Performance</h5>
                            
                            <div class="step-box mb-3">
                                <span class="step-number">1</span>
                                <div class="step-content">
                                    <h6>View Checklists</h6>
                                    <p>Click <strong>"Checklists"</strong> in the sidebar to see all assignments.</p>
                                    <a href="{{ route('owner.checklists.index') }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-clipboard-check me-1"></i>Go to Checklists
                                    </a>
                                </div>
                            </div>

                            <div class="step-box mb-3">
                                <span class="step-number">2</span>
                                <div class="step-content">
                                    <h6>View Individual Checklist Details</h6>
                                    <p>Click <strong>"View"</strong> on any checklist to see:</p>
                                    <ul>
                                        <li>Which tasks were completed</li>
                                        <li>Inventory status (items available/missing)</li>
                                        <li>Photos uploaded by housekeeper (with timestamps)</li>
                                        <li>GPS check-in location and time</li>
                                        <li>Start and completion times</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="step-box">
                                <span class="step-number">3</span>
                                <div class="step-content">
                                    <h6>Review Photos</h6>
                                    <p>All photos include automatic timestamp overlays (burned into the image, not editable) to verify when work was completed.</p>
                                </div>
                            </div>

                            <div class="alert alert-success mt-4">
                                <h6 class="alert-heading"><i class="bi bi-shield-check me-2"></i>Quality Assurance Features</h6>
                                <ul class="mb-0">
                                    <li><strong>GPS Verification:</strong> Housekeepers must be at the property location to start work</li>
                                    <li><strong>Photo Requirements:</strong> Minimum photos per room (configurable, default 8)</li>
                                    <li><strong>Timestamp Overlay:</strong> Photos have permanent timestamps</li>
                                    <li><strong>Sequential Workflow:</strong> Must complete tasks → inventory → photos in order</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Troubleshooting -->
                    <div id="troubleshooting" class="card shadow-sm mb-4">
                        <div class="card-header bg-danger text-white">
                            <h4 class="mb-0"><i class="bi bi-tools me-2"></i>8. Troubleshooting</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-danger mb-3">Common Issues and Solutions</h5>
                            
                            <div class="accordion" id="troubleshootingAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#issue1">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Cannot Create Assignment - Property Disabled
                                        </button>
                                    </h2>
                                    <div id="issue1" class="accordion-collapse collapse show" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Problem:</strong> Property appears disabled in the assignment form.</p>
                                            <p><strong>Solution:</strong></p>
                                            <ol>
                                                <li>Go to Properties → View the property</li>
                                                <li>Make sure it has at least one room created</li>
                                                <li>Make sure at least one room has tasks assigned to it</li>
                                                <li>Once both conditions are met, the property becomes available</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#issue2">
                                            <i class="bi bi-exclamation-triangle me-2"></i>No Housekeepers Available
                                        </button>
                                    </h2>
                                    <div id="issue2" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Problem:</strong> Cannot create assignments because no housekeepers exist.</p>
                                            <p><strong>Solution:</strong></p>
                                            <ol>
                                                <li>Go to Housekeepers → Add Housekeeper</li>
                                                <li>Create at least one housekeeper account</li>
                                                <li>Return to assignment creation</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#issue3">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Housekeeper Can't Start Checklist
                                        </button>
                                    </h2>
                                    <div id="issue3" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Problem:</strong> Housekeeper gets "GPS verification failed" error.</p>
                                            <p><strong>Solution:</strong></p>
                                            <ol>
                                                <li>Verify the property has correct GPS coordinates (latitude/longitude)</li>
                                                <li>Housekeeper must enable location services on their device</li>
                                                <li>Housekeeper must be within 100 meters of the property</li>
                                                <li>If using a desktop computer for testing, GPS may not work (use mobile device)</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#issue4">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Can't Delete an Assignment
                                        </button>
                                    </h2>
                                    <div id="issue4" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Problem:</strong> Delete button doesn't work or shows error.</p>
                                            <p><strong>Solution:</strong></p>
                                            <p>You can only delete assignments with "Pending" status. Once a housekeeper starts working (status changes to "In Progress"), the assignment cannot be deleted. This protects completed work from accidental deletion.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#issue5">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Photos Don't Show Timestamp
                                        </button>
                                    </h2>
                                    <div id="issue5" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Problem:</strong> Uploaded photos don't have visible timestamps.</p>
                                            <p><strong>Solution:</strong></p>
                                            <p>This should not happen if the PHP GD extension is enabled. Contact your system administrator to verify:</p>
                                            <ul>
                                                <li>PHP GD extension is installed and enabled</li>
                                                <li>Intervention Image package is installed (composer.json)</li>
                                                <li>Check application logs for image processing errors</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Reference -->
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-lightning-fill me-2"></i>Quick Reference</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Essential Pages</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('owner.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.properties.index') }}"><i class="bi bi-building me-2"></i>Properties</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.housekeepers.index') }}"><i class="bi bi-person-badge me-2"></i>Housekeepers</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.tasks.index') }}"><i class="bi bi-list-check me-2"></i>Tasks</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.checklists.index') }}"><i class="bi bi-clipboard-check me-2"></i>Checklists</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="{{ route('owner.assign-housekeeper') }}"><i class="bi bi-person-plus me-2"></i>Assign Housekeeper</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.calendar') }}"><i class="bi bi-calendar-check me-2"></i>Schedule Cleaning</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.properties.create') }}"><i class="bi bi-building-add me-2"></i>Add Property</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.housekeepers.create') }}"><i class="bi bi-person-plus-fill me-2"></i>Add Housekeeper</a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="{{ route('owner.tasks.create') }}"><i class="bi bi-plus-circle me-2"></i>Add Task</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.step-box {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-left: 4px solid #667eea;
    border-radius: 8px;
}

.step-number {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.25rem;
}

.step-content {
    flex: 1;
}

.step-content h6 {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.step-content p {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.step-content ul {
    margin-bottom: 0;
}

.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.list-group-item {
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background: #f8f9fa;
    border-left-color: #667eea;
    padding-left: 1.5rem;
}

.accordion-button {
    font-weight: 600;
}

.accordion-button:not(.collapsed) {
    background: #e7f3ff;
    color: #0d6efd;
}

.alert-heading {
    font-weight: 700;
}

html {
    scroll-behavior: smooth;
}
</style>

<script>
// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection
