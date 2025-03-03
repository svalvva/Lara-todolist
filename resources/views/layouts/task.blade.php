<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            background-color: #6b21a8;
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar.expanded {
            width: 250px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            background-color: #7e22ce;
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .sidebar-header span {
            display: none;
        }

        /* Main content */
        .main-content {
            transition: margin-left 0.3s;
        }

        .main-content.sidebar-expanded {
            margin-left: 250px;
        }

        .main-content.sidebar-collapsed {
            margin-left: 60px;
        }

        /* Topbar */
        .topbar {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 20px;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ff6b6b, #ff4757);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #ff5252, #ff3f4f);
        }

        .btn-logout:active {
            transform: translateY(0);
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-logout i {
            font-size: 1.1em;
        }

        /* Custom styles */
        .btn-purple {
            background-color: #6b21a8;
            color: white;
        }

        .btn-purple:hover {
            background-color: #7e22ce;
            color: white;
        }

        .text-purple {
            color: #6b21a8;
        }

        .bg-purple-light {
            background-color: #f3e8ff;
        }

        .table th {
            background-color: #f3e8ff;
            color: #6b21a8;
            font-weight: 600;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-tertunda {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #065f46;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #a855f7;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9333ea;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar expanded">
            <div class="sidebar-header p-3 d-flex justify-content-center">
                <h4 class="m-0"><span>To Do List</span></h4>
            </div>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>Semua Tugas</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="main-content sidebar-expanded flex-grow-1">
            <!-- Topbar -->
            <div class="topbar d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <button id="sidebarToggle" class="btn btn-sm">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="ms-3 fw-bold text-purple">To-Do-List</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <!-- Trigger -->
                        <div class="dropdown-toggle profile-toggle d-flex align-items-center" data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="cursor: pointer; padding: 8px 12px; border-radius: 8px; transition: all 0.3s ease;">
                            <i class="fas fa-user-circle me-2 fs-4 text-purple"></i>
                            <div class="text-start">
                                <span class="d-block small fw-bold text-dark">{{ Str::limit(Auth::user()->name ?? 'User', 15) }}</span>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                            style="min-width: 200px; margin-top: 10px;">
                            <li>
                                <div class="dropdown-header">
                                    <h6 class="fw-bold text-purple mb-0">{{ Auth::user()->name }}</h6>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider mx-3 my-2">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2">
                                        <i class="fas fa-sign-out-alt me-3 text-danger"></i>
                                        <span class="text-dark">Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Page Content -->
            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                sidebar.classList.toggle('expanded');
                mainContent.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('sidebar-expanded');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
