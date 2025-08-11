<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Stok</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="toast-container">
        <div class="toast toast-demo" id="demoToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-transparent border-0 text-white">
                <i class="fas fa-info-circle me-2"></i>
                <strong class="me-auto">Login Demo</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                <div class="mb-2">
                    <strong>Email:</strong> admin@example.com
                </div>
                <div>
                    <strong>Password:</strong> password
                </div>
                <small class="text-light opacity-75 mt-2 d-block">
                    <i class="fas fa-clock me-1"></i>
                    Gunakan akun ini untuk testing
                </small>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-container row g-0 mx-auto">
                    <div class="col-lg-6 login-left">
                        <a href="{{ route('home') }}" class="back-btn">
                            <i class="fas fa-arrow-left me-2"></i>Beranda
                        </a>

                        <div class="text-center mb-4">
                            <i class="fas fa-boxes brand-logo"></i>
                            <h2 class="brand-title">Manajer Stok</h2>
                            <p class="brand-subtitle">Sistem Inventaris Profesional</p>
                        </div>

                        <div>
                            <div class="feature-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Analitik Stok Real-time</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transaksi Multi-Produk</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Manajemen Admin yang Aman</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-mobile-alt"></i>
                                <span>Desain Responsif</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 login-right">
                        <h3 class="login-title">Selamat Datang Kembali!</h3>
                        <p class="login-subtitle">Masuk ke akun admin Anda</p>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Alamat Email
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius: 12px 0 0 12px;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        style="border-radius: 0 12px 12px 0;" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="admin@example.com" required>
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Kata Sandi
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius: 12px 0 0 0;">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="password" required>
                                    <button type="button" class="input-group-text password-toggle"
                                        style="border-radius: 0 12px 0 0;" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya selama 30 hari
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Masuk ke Dasbor
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Otentikasi admin yang aman
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tampilkan toast demo setelah halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var toast = new bootstrap.Toast(document.getElementById('demoToast'), {
                    autohide: false // Jangan sembunyikan otomatis, biarkan pengguna menutupnya
                });
                toast.show();
            }, 1500);
        });

        // Fungsi untuk menampilkan/menyembunyikan kata sandi
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
