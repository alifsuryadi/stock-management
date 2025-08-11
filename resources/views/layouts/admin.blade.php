<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Stock Management System')</title>

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <button class="sidebar-close-btn d-lg-none" id="sidebarCloseBtn">
                    <i class="fas fa-times"></i>
                </button>
                <i class="fas fa-boxes sidebar-logo"></i>
                <h4 class="sidebar-title">Stock Manager</h4>
                <p class="sidebar-subtitle">Inventory System</p>
            </div>

            <ul class="sidebar-nav list-unstyled">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}"
                        href="{{ route('admin.admins.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Kelola Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                        href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}"
                        href="{{ route('admin.transactions.index') }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('admin.logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="button" class="nav-link w-100 border-0" onclick="showLogoutModal()">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Top Bar -->
            <div class="topbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="hamburger d-lg-none" id="hamburgerBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title ms-3">@yield('header', 'Dashboard')</h1>
                </div>

                <div class="d-flex align-items-center">
                    <div class="profile-dropdown" id="profileDropdown">
                        <button class="profile-btn dropdown-toggle border-0" type="button">
                            <i class="fas fa-user-circle me-2"></i>
                            Welcome back, {{ Auth::guard('admin')->user()->first_name }}!
                        </button>
                        <div class="profile-dropdown-menu">
                            <div class="profile-info">
                                <p class="profile-name">{{ Auth::guard('admin')->user()->full_name }}</p>
                                <p class="profile-email">{{ Auth::guard('admin')->user()->email }}</p>
                            </div>
                            <a href="{{ route('admin.profile') }}" class="profile-menu-item">
                                <i class="fas fa-user me-2"></i>
                                Profil Saya
                            </a>
                            <a href="#" class="profile-menu-item" onclick="showLogoutModal()">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="deleteMessage">Apakah Anda yakin ingin menghapus item ini?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fas fa-sign-out-alt text-primary me-2"></i>
                        Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin keluar dari dashboard?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }

        hamburgerBtn?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);
        sidebarCloseBtn?.addEventListener('click', toggleSidebar);

        // Profile Dropdown
        const profileDropdown = document.getElementById('profileDropdown');
        const profileBtn = profileDropdown.querySelector('.profile-btn');

        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function() {
            profileDropdown.classList.remove('show');
        });

        // Delete Modal
        let deleteForm = null;

        function showDeleteModal(form, message = 'Apakah Anda yakin ingin menghapus item ini?') {
            deleteForm = form;
            document.getElementById('deleteMessage').textContent = message;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        document.getElementById('confirmDelete')?.addEventListener('click', function() {
            if (deleteForm) {
                deleteForm.submit();
            }
        });

        // Logout Modal
        function showLogoutModal() {
            new bootstrap.Modal(document.getElementById('logoutModal')).show();
        }

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>

</html>
