<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">


</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="error-container">
                    <i class="fas fa-exclamation-triangle floating-icon"></i>
                    <div class="error-code">404</div>
                    <h1 class="error-title">Halaman Tidak Ditemukan</h1>
                    <p class="error-subtitle">
                        Maaf, halaman yang Anda cari tidak dapat ditemukan.
                        Mungkin halaman telah dipindahkan atau tidak tersedia.
                    </p>

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('home') }}" class="btn-home">
                            <i class="fas fa-home me-2"></i>Kembali ke Home
                        </a>
                        <a href="{{ route('admin.login') }}" class="btn-home">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
