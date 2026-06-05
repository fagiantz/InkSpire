<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F7FC;
            color: #1E293B;
            margin: 0;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-top: 10px;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: #64748B;
            margin-bottom: 36px;
        }

        .sidebar-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 32px 24px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
            border: none;
        }

        .search-control {
            border: 1.5px solid #2563EB;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 0.9rem;
            color: #0F172A;
            transition: all 0.2s ease;
        }

        .search-control:focus {
            border-color: #1D4ED8;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .category-title {
            color: #2563EB;
            font-weight: 700;
            font-size: 1.05rem;
            margin-top: 24px;
            margin-bottom: 16px;
        }

        .category-item {
            margin-bottom: 12px;
        }

        .category-item .form-check-input {
            border-color: #2563EB;
            background-color: #ffffff;
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
        }

        .category-item .form-check-input:checked {
            background-color: #2563EB;
            border-color: #2563EB;
        }

        .category-item .form-check-label {
            font-weight: 500;
            font-size: 0.95rem;
            color: #1E293B;
            margin-left: 6px;
            cursor: pointer;
        }

        .product-link {
            text-decoration: none !important;
            color: inherit !important;
            display: block;
        }

        .product-card-custom {
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(13, 70, 183, 0.1);
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-link:hover .product-card-custom {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(13, 70, 183, 0.15);
        }

        .product-image-container {
            height: 180px;
            background-color: #E0ECFC;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 2px solid #2563EB;
            position: relative;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info-container {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product-description-text {
            color: #64748B;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container-fluid py-4 px-4">
        <!-- Title and Subtitle -->
        <h2 class="page-title">Katalog Produk</h2>
        <p class="page-subtitle">Pilih produk custom terbaik untuk kebutuhan Anda</p>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 mb-4 mb-md-0">
                <div class="sidebar-card">
                    <form action="{{ route('katalog') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-3">
                            <input type="text" name="query" class="form-control search-control"
                                placeholder="Cari Produk" value="{{ request('query') }}">
                        </div>

                        <!-- Kategori filter -->
                        <div class="category-title">Kategori</div>

                        <div class="category-item form-check">
                            <input class="form-check-input" value="" type="radio" name="cat" id="catAll"
                                onchange="this.form.submit()" {{ !request()->has('cat') || request('cat') == '' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catAll">Semua</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="banner" type="radio" name="cat" id="catBanner"
                                onchange="this.form.submit()" {{ request('cat') == 'banner' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catBanner">Banner</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="mug" type="radio" name="cat" id="catMug"
                                onchange="this.form.submit()" {{ request('cat') == 'mug' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catMug">Custom Mug</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="poster" type="radio" name="cat" id="catPoster"
                                onchange="this.form.submit()" {{ request('cat') == 'poster' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catPoster">Poster</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="keychain" type="radio" name="cat" id="catKeychain"
                                onchange="this.form.submit()" {{ request('cat') == 'keychain' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catKeychain">Keychain</label>
                        </div>
                        <div class="category-item form-check">
                            <input class="form-check-input" value="sticker" type="radio" name="cat" id="catStiker"
                                onchange="this.form.submit()" {{ request('cat') == 'sticker' ? 'checked' : '' }}>
                            <label class="form-check-label" for="catStiker">Sticker</label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-lg-10 col-md-9">
                <div class="row g-4">
                    @forelse ($produks as $produk)
                        <div class="col-6 col-lg-3">
                            <a href="{{ route('produk.detail', $produk['id_produk']) }}" class="product-link">
                                <div class="product-card-custom">
                                    <!-- Gambar Produk -->
                                    <div class="product-image-container">
                                        @if(!empty($produk['image_produk']))
                                            <img src="{{ route('products.image', $produk['image_produk']) }}"
                                                alt="{{ $produk['nama_produk'] }}">
                                        @else
                                            <i class="bi bi-image text-primary fs-2"></i>
                                        @endif
                                    </div>
                                    <!-- Info Produk -->
                                    <div class="product-info-container">
                                        <h6 class="product-name-title">{{ $produk['nama_produk'] }}</h6>
                                        <div class="mb-2">
                                            <span class="badge rounded-pill text-white"
                                                style="background-color: #2563EB; font-size: 0.75rem; padding: 4px 10px;">
                                                {{ ucfirst($produk['kategori'] ?? '') }}
                                            </span>
                                        </div>
                                        <p class="fw-bold text-primary mb-0 mt-auto" style="font-size: 1.05rem;">
                                            Rp {{ number_format($produk['harga'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 bg-white rounded-5 shadow-sm">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="mt-3 text-muted">Belum ada produk tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    @include("partials.footer")
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>