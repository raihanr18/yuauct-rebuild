<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- Custom Admin Styles -->
    <style>
        :root {
            --admin-primary: #6f42c1;
            --admin-secondary: #6c757d;
            --admin-success: #198754;
            --admin-danger: #dc3545;
            --admin-warning: #ffc107;
            --admin-info: #0dcaf0;
            --admin-light: #f8f9fa;
            --admin-dark: #212529;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--admin-primary) 0%, #5a32a3 100%);
            padding: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .admin-sidebar .sidebar-header {
            padding: 1.5rem;
            background: rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .admin-sidebar .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .admin-sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: #fff;
        }

        .admin-sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .admin-content {
            padding: 2rem;
            width: 100%;
            overflow-x: hidden;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.2s ease;
            height: 100%;
            width: 100%;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .stats-card .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #6c757d;
        }

        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .table-card .card-header {
            background: var(--admin-light);
            border-bottom: 1px solid #dee2e6;
            padding: 1.25rem;
            flex-shrink: 0;
        }

        .table-card .card-body {
            flex: 1;
            padding: 1.25rem;
            overflow-y: auto;
        }

        .table-card .card-footer {
            padding: 1rem 1.25rem;
            background: var(--admin-light);
            border-top: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        .btn-admin {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .alert-dismissible {
            border-radius: 8px;
            border: none;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .admin-content {
                padding: 1rem;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
        }

        /* Additional fixes for card content */
        .row.g-4 {
            margin-right: -1.5rem;
            margin-left: -1.5rem;
        }

        .row.g-4 > * {
            padding-right: 1.5rem;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 1rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .list-group-item:first-child {
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Progress bars in role distribution */
        .progress {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        /* Ensure text doesn't overflow */
        .table-card h6,
        .table-card p,
        .table-card small {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Container adjustments */
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        /* Responsive text adjustments */
        @media (max-width: 576px) {
            .stats-card h3 {
                font-size: 1.5rem;
            }
            
            .table-card h5 {
                font-size: 1rem;
            }
            
            .list-group-item {
                padding: 0.75rem;
            }
            
            .badge {
                font-size: 0.7em;
            }
        }

        /* Fix for long text in cards */
        .text-truncate-custom {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        @media (max-width: 768px) {
            .text-truncate-custom {
                max-width: 100px;
            }
        }
        
        /* Additional responsive fixes for card content */
        .list-group-item .flex-grow-1 {
            min-width: 0; /* Important for flexbox truncation */
        }
        
        .list-group-item .flex-shrink-0 {
            margin-left: 8px;
        }
        
        /* Better handling for system info cards */
        .system-info-item {
            min-height: 60px;
            display: flex;
            align-items: center;
        }
        
        .system-info-item .flex-grow-1 strong {
            font-size: 0.9rem;
            color: #495057;
        }
        
        .system-info-item .text-muted {
            font-size: 0.85rem;
            word-break: break-word;
        }
        
        /* Ensure tooltips work properly */
        [title] {
            cursor: help;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="sidebar-header">
                <h4><i class="bi bi-shield-check"></i> Admin Panel</h4>
            </div>
            
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                       href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i>
                        User Management
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.auctions.index') }}">
                        <i class="bi bi-hammer"></i>
                        Auctions
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.items.index') }}">
                        <i class="bi bi-box"></i>
                        Items
                    </a>
                </li>
                
                <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" 
                       href="{{ route('admin.settings') }}">
                        <i class="bi bi-gear"></i>
                        Settings
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}" 
                       href="{{ route('admin.logs') }}">
                        <i class="bi bi-file-text"></i>
                        System Logs
                    </a>
                </li>
                
                <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="bi bi-arrow-up-right-square"></i>
                        View Site
                    </a>
                </li>
                
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100" 
                                style="color: rgba(255,255,255,0.8);">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="admin-main flex-grow-1">
            <!-- Header -->
            <header class="admin-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary d-md-none me-2" type="button" 
                            data-bs-toggle="offcanvas" data-bs-target="#adminSidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i> Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="admin-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Admin Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirm delete actions
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
