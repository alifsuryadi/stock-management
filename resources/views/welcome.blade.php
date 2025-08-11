<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

</head>

<body>
    <div class="hero-section">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title floating">Stock Management System</h1>
                    <p class="hero-subtitle">
                        Kelola inventori bisnis Anda dengan mudah, efisien, dan real-time.
                        Sistem manajemen stok modern untuk kebutuhan bisnis masa kini.
                    </p>
                    <a href="{{ route('admin.login') }}" class="btn btn-hero">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Masuk ke Dashboard
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="features">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <h4 class="feature-title text-center">Manajemen Produk</h4>
                                <p class="feature-desc text-center">
                                    Kelola data produk dengan mudah termasuk kategori dan stok
                                </p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <h4 class="feature-title text-center">Transaksi Real-time</h4>
                                <p class="feature-desc text-center">
                                    Catat transaksi masuk dan keluar dengan validasi otomatis
                                </p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4 class="feature-title text-center">Dashboard Analytics</h4>
                                <p class="feature-desc text-center">
                                    Monitor performa stok dengan dashboard yang informatif
                                </p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h4 class="feature-title text-center">Multi Admin</h4>
                                <p class="feature-desc text-center">
                                    Sistem autentikasi aman dengan manajemen admin
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
