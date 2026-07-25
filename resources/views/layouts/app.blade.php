<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Arsip Digital USBR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #6366f1;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #1f2937;
            --light: #f3f4f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #374151;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h5 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 18px;
        }

        .sidebar-brand p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            margin: 5px 0 0 0;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            padding: 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
            padding-left: 25px;
        }

        .sidebar-menu a i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
            padding: 20px;
        }

        .stat-card {
            text-align: center;
            padding: 25px;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin: 10px 0;
        }

        .stat-card-label {
            color: #6b7280;
            font-size: 14px;
        }

        .stat-card-icon {
            font-size: 40px;
            color: var(--primary);
            opacity: 0.1;
        }

        .btn-custom {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .table {
            background: white;
        }

        .table thead th {
            background-color: var(--light);
            border: none;
            font-weight: 600;
            color: var(--dark);
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 10px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 15px 15px 0 0;
        }

        .page-link {
            color: var(--primary);
            border-radius: 5px;
            margin: 0 2px;
        }

        .page-link:hover {
            background-color: var(--primary);
            color: white;
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .page-title {
                font-size: 22px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                position: static;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h5><i class="fas fa-archive"></i> Arsip Digital</h5>
            <p>USBR</p>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="@if(Route::currentRouteName() == 'dashboard') active @endif">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('documents.index') }}" class="@if(Route::currentRouteNameMatches('documents.*')) active @endif">
                    <i class="fas fa-file-pdf"></i> Dokumen
                </a>
            </li>
            @if(auth()->user()->can('category.view') || auth()->user()->can('workunit.view') || auth()->user()->can('user.view'))
            <li style="margin-top: 15px; padding: 10px 20px; color: rgba(255, 255, 255, 0.5); font-size: 12px; font-weight: 600; text-transform: uppercase;">
                ADMIN PANEL
            </li>
            @endif
            @if(auth()->user()->can('category.view'))
            <li>
                <a href="{{ route('admin.categories.index') }}" class="@if(Route::currentRouteNameMatches('admin.categories.*')) active @endif">
                    <i class="fas fa-tags"></i> Kategori
                </a>
            </li>
            @endif
            @if(auth()->user()->can('workunit.view'))
            <li>
                <a href="{{ route('admin.work-units.index') }}" class="@if(Route::currentRouteNameMatches('admin.work-units.*')) active @endif">
                    <i class="fas fa-building"></i> Unit Kerja
                </a>
            </li>
            @endif
            @if(auth()->user()->can('user.view'))
            <li>
                <a href="{{ route('admin.users.index') }}" class="@if(Route::currentRouteNameMatches('admin.users.*')) active @endif">
                    <i class="fas fa-users"></i> Pengguna
                </a>
            </li>
            @endif
            @if(auth()->user()->can('activitylog.view'))
            <li>
                <a href="{{ route('admin.activity-logs.index') }}" class="@if(Route::currentRouteName() == 'admin.activity-logs.index') active @endif">
                    <i class="fas fa-history"></i> Activity Log
                </a>
            </li>
            @endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h6 style="margin: 0; color: #6b7280; font-size: 14px;">Selamat datang,</h6>
                <h5 style="margin: 5px 0 0 0; color: var(--dark);">{{ auth()->user()->name }}</h5>
            </div>
            <div class="topbar-right">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Confirm delete action
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
        }
    </script>
    @yield('extra-js')
</body>
</html>
