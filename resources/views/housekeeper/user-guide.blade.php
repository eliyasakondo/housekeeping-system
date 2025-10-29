@extends('layouts.app')

@section('content')
<div class="container-fluid py-3 py-md-4">
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h4 h3-md mb-1">
                        <i class="bi bi-book-fill text-success me-2"></i>
                        Housekeeper User Guide
                    </h1>
                    <p class="text-muted mb-0 small">Your complete guide to using the app</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Mobile-Optimized Table of Contents -->
        <div class="col-lg-3 mb-3 mb-lg-4">
            <div class="card mobile-toc">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 h6 h5-md">
                        <i class="bi bi-list-ul me-2"></i>
                        Quick Links
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#getting-started" class="list-group-item list-group-item-action">
                        <i class="bi bi-play-circle me-2"></i>Getting Started
                    </a>
                    <a href="#dashboard" class="list-group-item list-group-item-action">
                        <i class="bi bi-clipboard-check me-2"></i>My Checklists
                    </a>
                    <a href="#starting-work" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt me-2"></i>Starting Work
                    </a>
                    <a href="#completing-tasks" class="list-group-item list-group-item-action">
                        <i class="bi bi-check-square me-2"></i>Completing Tasks
                    </a>
                    <a href="#photos" class="list-group-item list-group-item-action">
                        <i class="bi bi-camera me-2"></i>Taking Photos
                    </a>
                    <a href="#calendar" class="list-group-item list-group-item-action">
                        <i class="bi bi-calendar me-2"></i>My Schedule
                    </a>
                    <a href="#tips" class="list-group-item list-group-item-action">
                        <i class="bi bi-lightbulb me-2"></i>Pro Tips
                    </a>
                    <a href="#faq" class="list-group-item list-group-item-action">
                        <i class="bi bi-question-circle me-2"></i>FAQ
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Getting Started -->
            <div id="getting-started" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-play-circle me-2"></i>
                        Getting Started
                    </h4>
                </div>
                <div class="card-body">
                    <h5 class="text-success h6 h5-md">Welcome!</h5>
                    <p>This guide will help you use the housekeeping app on your mobile phone or tablet.</p>
                    
                    <div class="alert alert-success mobile-alert">
                        <i class="bi bi-phone me-2"></i>
                        <strong>Mobile Friendly:</strong> This app works great on your phone! Add it to your home screen for quick access.
                    </div>

                    <h6 class="text-success mt-4">What You Can Do</h6>
                    <div class="row g-2 g-md-3">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                        <div>
                                            <h6 class="mb-1">View Your Assignments</h6>
                                            <p class="small text-muted mb-0">See all properties you need to clean</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                        <div>
                                            <h6 class="mb-1">Check Your Schedule</h6>
                                            <p class="small text-muted mb-0">View upcoming work on the calendar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                        <div>
                                            <h6 class="mb-1">Complete Tasks</h6>
                                            <p class="small text-muted mb-0">Mark tasks as done room by room</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                                        <div>
                                            <h6 class="mb-1">Upload Photos</h6>
                                            <p class="small text-muted mb-0">Take pictures of completed work</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success mt-4">How to Add App to Home Screen</h6>
                    <div class="accordion mobile-accordion" id="homeScreenAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#iphone">
                                    <i class="bi bi-apple me-2"></i> iPhone/iPad
                                </button>
                            </h2>
                            <div id="iphone" class="accordion-collapse collapse" data-bs-parent="#homeScreenAccordion">
                                <div class="accordion-body">
                                    <ol class="mb-0">
                                        <li>Open Safari and visit this website</li>
                                        <li>Tap the <strong>Share</strong> button (square with arrow)</li>
                                        <li>Scroll down and tap <strong>"Add to Home Screen"</strong></li>
                                        <li>Tap <strong>Add</strong> in the top right corner</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#android">
                                    <i class="bi bi-phone me-2"></i> Android
                                </button>
                            </h2>
                            <div id="android" class="accordion-collapse collapse" data-bs-parent="#homeScreenAccordion">
                                <div class="accordion-body">
                                    <ol class="mb-0">
                                        <li>Open Chrome and visit this website</li>
                                        <li>Tap the <strong>three dots</strong> menu (⋮)</li>
                                        <li>Tap <strong>"Add to Home screen"</strong></li>
                                        <li>Tap <strong>Add</strong> to confirm</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Checklists -->
            <div id="dashboard" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-clipboard-check me-2"></i>
                        My Checklists
                    </h4>
                </div>
                <div class="card-body">
                    <p>Your dashboard shows all your assigned cleaning jobs.</p>
                    
                    <h6 class="text-success mt-4">Checklist Status Colors</h6>
                    <div class="row g-2">
                        <div class="col-12 col-sm-4">
                            <div class="card border-warning mobile-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="status-badge bg-warning me-2"></div>
                                        <div>
                                            <h6 class="mb-0 small">PENDING</h6>
                                            <p class="text-muted mb-0 small">Not started yet</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="card border-info mobile-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="status-badge bg-info me-2"></div>
                                        <div>
                                            <h6 class="mb-0 small">IN PROGRESS</h6>
                                            <p class="text-muted mb-0 small">Currently working</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="card border-success mobile-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="status-badge bg-success me-2"></div>
                                        <div>
                                            <h6 class="mb-0 small">COMPLETED</h6>
                                            <p class="text-muted mb-0 small">All done!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success mt-4">Viewing a Checklist</h6>
                    <ol>
                        <li>Tap on any checklist card to view details</li>
                        <li>You'll see:
                            <ul>
                                <li>Property name and address</li>
                                <li>All rooms you need to clean</li>
                                <li>Tasks for each room</li>
                                <li>Photo requirements</li>
                            </ul>
                        </li>
                    </ol>

                    <div class="alert alert-info mobile-alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Tip:</strong> Pending checklists appear at the top of your dashboard. Start these first!
                    </div>
                </div>
            </div>

            <!-- Starting Work -->
            <div id="starting-work" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-geo-alt me-2"></i>
                        Starting Work
                    </h4>
                </div>
                <div class="card-body">
                    <h6 class="text-success">Step-by-Step Guide</h6>
                    
                    <div class="timeline-mobile">
                        <div class="timeline-item">
                            <div class="timeline-number">1</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Open the Checklist</h6>
                                <p class="text-muted small mb-0">Tap on the checklist card from your dashboard</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-number">2</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Go to the Property</h6>
                                <p class="text-muted small mb-2">Travel to the property address shown</p>
                                <div class="alert alert-warning mb-0 py-2">
                                    <i class="bi bi-geo-alt-fill me-1"></i>
                                    <small><strong>GPS Required:</strong> For properties with GPS enabled, you must be within 100 meters to start work.</small>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-number">3</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Enable Location</h6>
                                <p class="text-muted small mb-0">Allow the app to access your phone's location when prompted</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-number">4</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Tap "Start Work"</h6>
                                <p class="text-muted small mb-2">Press the green <span class="badge bg-success">Start Work</span> button</p>
                                <div class="alert alert-info mb-0 py-2">
                                    <i class="bi bi-clock me-1"></i>
                                    <small>The app will record your start time automatically</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success mt-4">GPS Verification</h6>
                    <p class="small">Some properties require GPS verification:</p>
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="text-center">
                                        <i class="bi bi-check-circle-fill text-success fs-1"></i>
                                        <p class="mb-0 mt-2 small"><strong>Within Range</strong></p>
                                        <p class="text-muted mb-0 small">You can start work</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <i class="bi bi-x-circle-fill text-danger fs-1"></i>
                                        <p class="mb-0 mt-2 small"><strong>Too Far</strong></p>
                                        <p class="text-muted mb-0 small">Move closer to property</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mobile-alert mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> If you can't start work due to GPS, make sure:
                        <ul class="mb-0 mt-2 small">
                            <li>Location services are ON in your phone settings</li>
                            <li>You allowed the app to access location</li>
                            <li>You're at the correct property address</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Completing Tasks -->
            <div id="completing-tasks" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-check-square me-2"></i>
                        Completing Tasks
                    </h4>
                </div>
                <div class="card-body">
                    <p>Once work is started, you can complete tasks room by room.</p>
                    
                    <h6 class="text-success mt-4">Task Completion Process</h6>
                    <ol>
                        <li><strong>Select a Room:</strong> Tap on any room card to expand it</li>
                        <li><strong>Review Tasks:</strong> See the list of cleaning tasks for that room</li>
                        <li><strong>Complete Each Task:</strong> Tap the checkbox next to each task as you finish it
                            <div class="card bg-light border-0 mt-2 mb-2">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2" disabled>
                                        <small class="text-muted">Vacuum floors</small>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <input type="checkbox" class="form-check-input me-2" checked disabled>
                                        <small><s>Dust surfaces</s></small>
                                        <i class="bi bi-check-circle-fill text-success ms-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><strong>Complete the Room:</strong> Once all tasks are checked, tap <button class="btn btn-sm btn-success">Complete Room</button></li>
                    </ol>

                    <h6 class="text-success mt-4">Room Progress Indicator</h6>
                    <p class="small">Each room shows your progress:</p>
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Bedroom Progress</span>
                                    <span><strong>3 / 5 tasks</strong></span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 60%">60%</div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Bathroom Progress</span>
                                    <span><strong>4 / 4 tasks</strong></span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mobile-alert mt-3">
                        <i class="bi bi-star me-2"></i>
                        <strong>Pro Tip:</strong> Complete one room at a time. This helps you stay organized and track your progress easily!
                    </div>
                </div>
            </div>

            <!-- Taking Photos -->
            <div id="photos" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-camera me-2"></i>
                        Taking Photos
                    </h4>
                </div>
                <div class="card-body">
                    <p><strong>Photos are REQUIRED</strong> to prove your work is complete.</p>
                    
                    <h6 class="text-success mt-4">Photo Requirements</h6>
                    <div class="card bg-warning bg-opacity-10 border-warning">
                        <div class="card-body p-3">
                            <h6 class="text-warning mb-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Minimum Photos Required
                            </h6>
                            <p class="mb-2 small">Each checklist requires a <strong>minimum of 8 photos</strong> (or as specified by the property owner).</p>
                            <p class="mb-0 small">Photos must be taken AFTER completing work, and they will have a timestamp automatically added.</p>
                        </div>
                    </div>

                    <h6 class="text-success mt-4">How to Upload Photos</h6>
                    <div class="timeline-mobile">
                        <div class="timeline-item">
                            <div class="timeline-number">1</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Find the Photos Section</h6>
                                <p class="text-muted small mb-0">Scroll down in your checklist to the "Upload Photos" section</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-number">2</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Tap "Choose File" or Camera Icon</h6>
                                <p class="text-muted small mb-0">Your phone will ask to use the camera or gallery</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-number">3</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Take or Select Photos</h6>
                                <p class="text-muted small mb-0">Take new photos or choose from your gallery</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-number">4</div>
                            <div class="timeline-content">
                                <h6 class="mb-2">Upload Completes</h6>
                                <p class="text-muted small mb-2">Wait for the green success message</p>
                                <div class="alert alert-success mb-0 py-2">
                                    <i class="bi bi-check-circle me-1"></i>
                                    <small>A timestamp will be automatically added to your photo</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success mt-4">Photo Tips for Mobile</h6>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <div class="card border-success h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success small">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Good Photos
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Well-lit and clear</li>
                                        <li>Show the completed work</li>
                                        <li>Different angles/rooms</li>
                                        <li>Hold phone steady</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-danger h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-danger small">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Avoid
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Blurry images</li>
                                        <li>Too dark or too bright</li>
                                        <li>Photos before cleaning</li>
                                        <li>Unrelated images</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-success mt-4">Timestamp Overlay</h6>
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-clock-history text-primary fs-3 me-3"></i>
                                <div>
                                    <h6 class="mb-1">Automatic Timestamp</h6>
                                    <p class="small text-muted mb-2">The system automatically adds a timestamp to every photo showing the date and time it was uploaded.</p>
                                    <p class="small mb-0"><strong>This timestamp cannot be edited or removed</strong> - it proves when the work was done.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mobile-alert mt-3">
                        <i class="bi bi-wifi me-2"></i>
                        <strong>Internet Required:</strong> You need a good internet connection to upload photos. Use WiFi when possible to save mobile data.
                    </div>
                </div>
            </div>

            <!-- My Schedule -->
            <div id="calendar" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-calendar me-2"></i>
                        My Schedule
                    </h4>
                </div>
                <div class="card-body">
                    <p>View all your upcoming cleaning assignments on the calendar.</p>
                    
                    <h6 class="text-success mt-4">Using the Calendar</h6>
                    <ol>
                        <li>Tap <strong>My Schedule</strong> in the menu</li>
                        <li>See all your assignments:
                            <ul>
                                <li><span class="badge bg-warning text-dark">Yellow</span> = Pending assignments</li>
                                <li><span class="badge bg-info">Blue</span> = Work in progress</li>
                                <li><span class="badge bg-success">Green</span> = Completed work</li>
                            </ul>
                        </li>
                        <li>Tap on any event to see full details</li>
                    </ol>

                    <h6 class="text-success mt-4">Mobile Calendar Views</h6>
                    <div class="row g-2">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card bg-light border-0 text-center p-3">
                                <i class="bi bi-calendar-month text-primary fs-2"></i>
                                <h6 class="mt-2 mb-1 small">Month View</h6>
                                <p class="text-muted mb-0 small">See the whole month</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card bg-light border-0 text-center p-3">
                                <i class="bi bi-calendar-week text-primary fs-2"></i>
                                <h6 class="mt-2 mb-1 small">Week View</h6>
                                <p class="text-muted mb-0 small">See this week</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card bg-light border-0 text-center p-3">
                                <i class="bi bi-calendar-day text-primary fs-2"></i>
                                <h6 class="mt-2 mb-1 small">Day View</h6>
                                <p class="text-muted mb-0 small">Today's schedule</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mobile-alert mt-3">
                        <i class="bi bi-calendar-check me-2"></i>
                        <strong>Tip:</strong> Check your calendar every morning to see which properties you need to clean today!
                    </div>
                </div>
            </div>

            <!-- Pro Tips -->
            <div id="tips" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-lightbulb me-2"></i>
                        Pro Tips
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-battery-charging me-2"></i>
                                        Keep Phone Charged
                                    </h6>
                                    <p class="small mb-0">Bring a portable charger. You'll need your phone for GPS, photos, and task completion.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-wifi me-2"></i>
                                        Use WiFi When Available
                                    </h6>
                                    <p class="small mb-0">Connect to property WiFi to save mobile data when uploading photos.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-check2-all me-2"></i>
                                        Complete One Room at a Time
                                    </h6>
                                    <p class="small mb-0">Focus on finishing one room completely before moving to the next.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-camera me-2"></i>
                                        Take Photos as You Go
                                    </h6>
                                    <p class="small mb-0">Don't wait until the end. Take photos after completing each room.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-geo-alt me-2"></i>
                                        Enable Location Always
                                    </h6>
                                    <p class="small mb-0">Set location permission to "Always Allow" in phone settings for faster start times.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-clock me-2"></i>
                                        Check Schedule Daily
                                    </h6>
                                    <p class="small mb-0">Review tomorrow's schedule each evening so you're prepared.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-bookmark me-2"></i>
                                        Bookmark the App
                                    </h6>
                                    <p class="small mb-0">Add the website to your home screen for quick access like a real app.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body p-3">
                                    <h6 class="text-success">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Keep App Open
                                    </h6>
                                    <p class="small mb-0">Don't close the browser while working to avoid losing progress.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mobile-alert mt-3">
                        <i class="bi bi-star-fill me-2"></i>
                        <strong>Best Practice:</strong> Start work → Complete tasks → Take photos → Complete checklist. Follow this flow every time!
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div id="faq" class="card mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-question-circle me-2"></i>
                        Frequently Asked Questions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="accordion mobile-accordion" id="faqAccordion">
                        <!-- Question 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">What if I can't start work due to GPS?</span>
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-2">Make sure:</p>
                                    <ul class="small mb-0">
                                        <li>Location services are turned ON in your phone settings</li>
                                        <li>You gave the browser/app permission to access location</li>
                                        <li>You're within 100 meters of the property</li>
                                        <li>You're at the correct property address</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Question 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">How many photos do I need to take?</span>
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">Minimum is <strong>8 photos per checklist</strong>, but the property owner may require more. The exact number is shown on your checklist. Take clear photos of different rooms and angles to show your completed work.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">Can I edit a task after marking it complete?</span>
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">Yes! You can uncheck a task before completing the entire checklist. However, once you complete the full checklist, you cannot make any changes.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 4 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">What happens to the timestamp on photos?</span>
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">The system automatically adds a timestamp overlay to every photo showing the exact date and time. This timestamp cannot be edited or removed. It proves when the work was completed.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 5 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">What if I lose internet connection?</span>
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">You can continue checking off tasks without internet. However, you MUST have internet to upload photos and complete the checklist. Your progress is saved, so reconnect when you can finish.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 6 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">Can I see my completed work history?</span>
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">Yes! Your dashboard shows all checklists including completed ones. Tap on any completed checklist to review what you did, see your photos, and check completion times.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 7 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">Do I need to download an app?</span>
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">No! This is a web app that works in your phone's browser. Just add it to your home screen and it works like a native app. No app store needed!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 8 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">Who can see my work?</span>
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">The property owner and system administrators can view your completed checklists, photos, and work times. This helps ensure quality and provides proof of completion.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 9 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">What if there's a problem at the property?</span>
                                </button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">Take photos of any issues or damage you find. Contact the property owner or your supervisor immediately. Do not complete the checklist until you receive instructions.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Question 10 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <span class="small">Can I use this on a tablet?</span>
                                </button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p class="small mb-0">Yes! The app works on tablets, iPads, and phones. A tablet's larger screen can make it easier to view checklists and take photos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card border-success mb-3 mb-md-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 h5 h4-md">
                        <i class="bi bi-headset me-2"></i>
                        Need Help?
                    </h4>
                </div>
                <div class="card-body">
                    <p class="small">If you need assistance or have questions:</p>
                    <div class="row g-2">
                        <div class="col-12 col-sm-6">
                            <a href="tel:1-800-CLEAN-24" class="text-decoration-none">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3 text-center">
                                        <i class="bi bi-telephone-fill text-success fs-2"></i>
                                        <h6 class="mt-2 mb-1 small">Call Support</h6>
                                        <p class="text-muted mb-0 small">1-800-CLEAN-24</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6">
                            <a href="mailto:support@housekeeping.com" class="text-decoration-none">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3 text-center">
                                        <i class="bi bi-envelope-fill text-success fs-2"></i>
                                        <h6 class="mt-2 mb-1 small">Email Us</h6>
                                        <p class="text-muted mb-0 small">support@housekeeping.com</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile-Optimized Styles -->
<style>
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Mobile responsive font sizes */
    @media (max-width: 768px) {
        .h3-md { font-size: 1.5rem !important; }
        .h4-md { font-size: 1.25rem !important; }
        .h5-md { font-size: 1.1rem !important; }
    }

    /* Mobile-friendly TOC */
    .mobile-toc {
        position: sticky;
        top: 80px;
        max-height: calc(100vh - 100px);
        overflow-y: auto;
    }

    @media (max-width: 992px) {
        .mobile-toc {
            position: relative;
            top: 0;
            max-height: none;
        }
    }

    /* Mobile scrollbar */
    .mobile-toc::-webkit-scrollbar {
        width: 4px;
    }

    .mobile-toc::-webkit-scrollbar-thumb {
        background: #28a745;
        border-radius: 4px;
    }

    /* List group mobile optimization */
    .list-group-item-action {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .list-group-item-action:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #28a745;
        padding-left: calc(1rem - 3px);
    }

    /* Mobile alerts */
    .mobile-alert {
        font-size: 0.9rem;
        padding: 0.75rem;
    }

    /* Mobile cards */
    .mobile-card {
        transition: transform 0.2s;
    }

    .mobile-card:active {
        transform: scale(0.98);
    }

    /* Status badge */
    .status-badge {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Timeline for mobile */
    .timeline-mobile {
        position: relative;
        padding-left: 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 1.5rem;
        padding-left: 0.5rem;
    }

    .timeline-number {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .timeline-content {
        flex: 1;
        padding-top: 0.25rem;
    }

    @media (max-width: 576px) {
        .timeline-number {
            width: 32px;
            height: 32px;
            font-size: 1rem;
        }
    }

    /* Mobile accordion */
    .mobile-accordion .accordion-button {
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
    }

    .mobile-accordion .accordion-body {
        font-size: 0.9rem;
        padding: 1rem;
    }

    .mobile-accordion .accordion-button:not(.collapsed) {
        background-color: #d1f2dd;
        color: #155724;
    }

    /* Card animations */
    .card {
        transition: box-shadow 0.3s ease;
    }

    .card[id]:target {
        animation: highlight-mobile 1s ease-in-out;
    }

    @keyframes highlight-mobile {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    /* Touch-friendly buttons */
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Progress bar mobile */
    .progress {
        font-size: 0.75rem;
    }

    /* Improve tap targets for mobile */
    @media (max-width: 768px) {
        .accordion-button,
        .list-group-item-action,
        .btn {
            min-height: 44px;
        }
    }

    /* Mobile responsive images */
    img {
        max-width: 100%;
        height: auto;
    }

    /* Better spacing on mobile */
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        
        .card-header h4,
        .card-header h5 {
            font-size: 1rem;
        }
    }

    /* Alert icon sizing */
    .alert i {
        font-size: 1.1rem;
        vertical-align: middle;
    }

    /* Ensure text is readable on small screens */
    body {
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
    }
</style>

<script>
    // Smooth scroll with offset for mobile
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = window.innerWidth <= 768 ? 80 : 100;
                const offsetTop = target.offsetTop - offset;
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

    // Add haptic feedback on mobile (if supported)
    if ('vibrate' in navigator) {
        document.querySelectorAll('.btn, .list-group-item-action').forEach(element => {
            element.addEventListener('click', function() {
                navigator.vibrate(10);
            });
        });
    }

    // Prevent pull-to-refresh on mobile when scrolling up
    let touchStartY = 0;
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    }, { passive: true });

    document.addEventListener('touchmove', function(e) {
        const touchY = e.touches[0].clientY;
        const touchDiff = touchY - touchStartY;
        
        if (touchDiff > 0 && window.scrollY === 0) {
            e.preventDefault();
        }
    }, { passive: false });
</script>
@endsection
