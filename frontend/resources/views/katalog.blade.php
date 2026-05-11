<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #FEFEFD;
        }

        /* Styling sidebar */
        .sidebar {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper .form-control {
            border-color: #38BDF8;
            border-radius: 20px;
            padding-right: 40px;
        }

        .search-wrapper .search-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #333;
            font-size: 1.2rem;
        }

        .search-divider {
            height: 1px;
            background-color: #38BDF8;
            margin: 15px 0;
        }

        /* Kategori radio */
        .category-item {
            margin-bottom: 8px;
        }

        .category-item .form-check-input {
            border-color: #38BDF8;
            background-color: white;
        }

        .category-item .form-check-input:checked {
            background-color: #38BDF8;
            border-color: #38BDF8;
        }

        .category-item .form-check-label {
            font-weight: 500;
        }

        /* Product card */
        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            transition: 0.2s;
            background: white;
        }

        .product-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            background-color: #e9ecef;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .product-desc {
            color: #6c757d;
            font-size: 0.875rem;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="sidebar">
                    <h3 class="fw-bold mb-4">Katalog</h3>

                    <!-- Search -->
                    <div class="search-wrapper">
                        <input type="text" class="form-control" placeholder="Cari">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                    <div class="search-divider"></div>

                    <!-- Kategori filter -->
                    <div class="mb-3 fw-bold">Kategori</div>
                    <div class="category-item form-check">
                        <input class="form-check-input" type="radio" name="kategori" id="catBanner">
                        <label class="form-check-label" for="catBanner">Banner</label>
                    </div>
                    <div class="category-item form-check">
                        <input class="form-check-input" type="radio" name="kategori" id="catMug">
                        <label class="form-check-label" for="catMug">Custom Mug</label>
                    </div>
                    <div class="category-item form-check">
                        <input class="form-check-input" type="radio" name="kategori" id="catPoster">
                        <label class="form-check-label" for="catPoster">Poster</label>
                    </div>
                    <div class="category-item form-check">
                        <input class="form-check-input" type="radio" name="kategori" id="catKeychain">
                        <label class="form-check-label" for="catKeychain">Keychain</label>
                    </div>
                    <div class="category-item form-check">
                        <input class="form-check-input" type="radio" name="kategori" id="catStiker">
                        <label class="form-check-label" for="catStiker">Stiker</label>
                    </div>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9">
                <div class="row g-4">
                    @forelse ($produks as $produk)
                        <div class="col-6 col-lg-4">
                            <a href="{{ route('produk.detail', $produk['id_produk']) }}" class="text-decoration-none">
                                <div class="product-card">
                                    <div class="product-img">
                                        <i class="bi bi-image" style="font-size: 3rem; color: #38BDF8;"></i>
                                    </div>
                                    <div class="product-info">
                                        <h6 class="product-title">{{ $produk['nama_produk'] }}</h6>
                                        <p class="product-desc">Rp {{ number_format($produk['harga'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada produk tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted py-4">
        <small>&copy; 2025 InkSpire. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
