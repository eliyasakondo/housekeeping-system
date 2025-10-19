<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        // Get dynamic app name and favicon from saved settings or defaults
        $dynamicAppName = config('app.name', 'HK Checklist');
        $dynamicFavicon = asset('favicon.ico'); // Default favicon
        
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $dynamicAppName = $settings['app_name'] ?? $dynamicAppName;
        }
        
        // Check for custom favicon
        $faviconExtensions = ['ico', 'png'];
        foreach ($faviconExtensions as $ext) {
            if (Storage::disk('public')->exists("branding/favicon.{$ext}")) {
                $dynamicFavicon = asset("storage/branding/favicon.{$ext}");
                break;
            }
        }
    @endphp

    <title>@yield('title', $dynamicAppName)</title>
    
    <!-- Dynamic Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $dynamicFavicon }}"  id="favicon">

    <!-- Fonts - Modern & Professional -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom Professional CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        /* Sidebar Styles */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-260px);
        }

        /* Logo Section */
        .sidebar-logo {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-logo a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.025em;
        }

        .sidebar-logo i {
            font-size: 2rem;
            background: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        /* Navigation Menu */
        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .nav-section-title {
            padding: 1rem 1.5rem 0.5rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
            transform: translateX(-4px);
            transition: transform 0.3s ease;
        }

        .nav-link i {
            font-size: 1.5rem;
            width: 24px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(4px);
        }

        .nav-link:hover::before {
            transform: translateX(0);
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .nav-link.active::before {
            transform: translateX(0);
        }

        .nav-link.active i {
            transform: scale(1.1);
        }

        /* Featured Link */
        .nav-link.featured {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: pulse-featured 2s ease-in-out infinite;
        }

        @keyframes pulse-featured {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(255, 255, 255, 0);
            }
        }

        /* User Profile Section */
        .sidebar-user {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: white;
        }

        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            text-transform: capitalize;
        }

        .user-menu-icon {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Dropdown Menu for User */
        .user-dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 0.5rem;
            display: none;
        }

        .user-dropdown.show .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #2d3748;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: #f7fafc;
            color: #667eea;
        }

        .dropdown-item i {
            font-size: 1.25rem;
            width: 24px;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
            background: #f7fafc;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Top Bar (Mobile) */
        .top-bar {
            display: none;
            background: white;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-menu-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.05);
        }

        .top-bar-logo {
            font-weight: 800;
            color: #2d3748;
            font-size: 1.25rem;
        }

        /* Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Content Padding */
        .content-wrapper {
            padding: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                display: flex;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 1rem;
            }

            .sidebar-logo a {
                font-size: 1rem;
            }

            .sidebar-logo i {
                width: 40px;
                height: 40px;
                font-size: 1.5rem;
            }
        }

        /* Success/Error Alerts in Content */
        .content-wrapper .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div id="app">
        @guest
            <!-- Guest Layout (No Sidebar) -->
            <main>
                @yield('content')
            </main>
        @else
            <!-- Authenticated Layout (With Sidebar) -->
            <div class="app-wrapper">
                <!-- Sidebar Overlay (Mobile) -->
                <div class="sidebar-overlay" id="sidebarOverlay"></div>

                <!-- Sidebar -->
                <aside class="sidebar" id="sidebar">
                    <!-- Logo -->
                    <div class="sidebar-logo">
                        <a href="{{ route('home') }}">
                            <i class="bi bi-house-check-fill"></i>
                            <span>
                                @php
                                    // Get app name from saved settings or config
                                    $appName = config('app.name', 'HK Checklist');
                                    if (Storage::disk('local')->exists('settings.json')) {
                                        $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
                                        $appName = $settings['app_name'] ?? $appName;
                                    }
                                @endphp
                                {{ $appName }}
                            </span>
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="sidebar-menu">
                        @if(auth()->user()->isAdmin())
                            <div class="nav-section-title">Main Menu</div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}" href="{{ route('admin.properties.index') }}">
                                    <i class="bi bi-building-fill"></i>
                                    <span>Properties</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}">
                                    <i class="bi bi-door-open-fill"></i>
                                    <span>Rooms</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}" href="{{ route('admin.tasks.index') }}">
                                    <i class="bi bi-list-check"></i>
                                    <span>Tasks</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.checklists.*') ? 'active' : '' }}" href="{{ route('admin.checklists.index') }}">
                                    <i class="bi bi-clipboard-check-fill"></i>
                                    <span>Checklists</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.calendar') ? 'active' : '' }}" href="{{ route('admin.calendar') }}">
                                    <i class="bi bi-calendar-range-fill"></i>
                                    <span>Calendar</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-people-fill"></i>
                                    <span>Users</span>
                                </a>
                            </div>
                            
                            <div class="nav-section-title">System</div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                    <i class="bi bi-gear-fill"></i>
                                    <span>Settings</span>
                                </a>
                            </div>

                        @elseif(auth()->user()->isOwner())
                            <div class="nav-section-title">Main Menu</div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('owner.properties.*') ? 'active' : '' }}" href="{{ route('owner.properties.index') }}">
                                    <i class="bi bi-building-fill"></i>
                                    <span>Properties</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('owner.housekeepers.*') ? 'active' : '' }}" href="{{ route('owner.housekeepers.index') }}">
                                    <i class="bi bi-person-badge-fill"></i>
                                    <span>Housekeepers</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('owner.tasks.*') ? 'active' : '' }}" href="{{ route('owner.tasks.index') }}">
                                    <i class="bi bi-list-check"></i>
                                    <span>Tasks</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('owner.checklists.*') ? 'active' : '' }}" href="{{ route('owner.checklists.index') }}">
                                    <i class="bi bi-clipboard-check-fill"></i>
                                    <span>Checklists</span>
                                </a>
                            </div>
                            
                            <div class="nav-section-title">Quick Actions</div>
                            <div class="nav-item">
                                <a class="nav-link featured {{ request()->routeIs('owner.calendar') ? 'active' : '' }}" href="{{ route('owner.calendar') }}">
                                    <i class="bi bi-calendar-check-fill"></i>
                                    <span>Schedule Cleaning</span>
                                </a>
                            </div>

                        @elseif(auth()->user()->isHousekeeper())
                            <div class="nav-section-title">My Work</div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('housekeeper.dashboard') ? 'active' : '' }}" href="{{ route('housekeeper.dashboard') }}">
                                    <i class="bi bi-clipboard-check-fill"></i>
                                    <span>My Checklists</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('housekeeper.calendar') ? 'active' : '' }}" href="{{ route('housekeeper.calendar') }}">
                                    <i class="bi bi-calendar-event-fill"></i>
                                    <span>My Schedule</span>
                                </a>
                            </div>
                        @endif
                    </nav>

                    <!-- User Profile Section -->
                    <div class="sidebar-user">
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ Auth::user()->name }}</div>
                                    <div class="user-role">{{ Auth::user()->role }}</div>
                                </div>
                                <i class="bi bi-three-dots-vertical user-menu-icon"></i>
                            </div>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="main-content" id="mainContent">
                    <!-- Mobile Top Bar -->
                    <div class="top-bar">
                        <button class="mobile-menu-btn" id="mobileMenuBtn">
                            <i class="bi bi-list"></i>
                        </button>
                        <a href="{{ route('home') }}" class="top-bar-logo" style="text-decoration: none; color: inherit;">
                            <i class="bi bi-house-check-fill"></i> Housekeeping
                        </a>
                        <div style="width: 40px;"></div> <!-- Spacer -->
                    </div>

                    <!-- Content Wrapper -->
                    <div class="content-wrapper">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        @endguest
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const userDropdown = document.getElementById('userDropdown');

            // Mobile menu toggle
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }

            // User dropdown toggle
            if (userDropdown) {
                const userProfile = userDropdown.querySelector('.user-profile');
                userProfile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('show');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target)) {
                        userDropdown.classList.remove('show');
                    }
                });
            }

            // Close mobile menu when clicking nav link
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
