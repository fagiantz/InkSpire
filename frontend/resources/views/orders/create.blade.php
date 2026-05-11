<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Pesanan - InkSpire</title>
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

        .product-image {
            background-color: #e9ecef;
            border-radius: 12px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="container py-4">
        <h2 class="fw-bold mb-4">Buat Pesanan</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <!-- Detail Produk -->
            <div class="col-md-6">
                <div class="product-image mb-3">
                    <i class="bi bi-image" style="font-size: 4rem; color: #38BDF8;"></i>
                </div>
                <h4 class="fw-bold">{{ $produk['nama_produk'] }}</h4>
                <p class="text-muted">Harga satuan: Rp {{ number_format($produk['harga'], 0, ',', '.') }}</p>
            </div>

            <!-- Form Pemesanan -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-4" style="border: 2px solid #38BDF8;">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $produk['id_produk'] }}">

                            <div class="mb-3">
                                <label for="kuantitas" class="form-label fw-semibold">Jumlah</label>
                                <input type="number" class="form-control" id="kuantitas" name="kuantitas"
                                    min="1" value="1" required style="border-color: #38BDF8;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Harga</label>
                                <div class="form-control bg-light" style="border-color: #ccc;">
                                    Rp <span id="totalHarga">{{ number_format($produk['harga'], 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-lg w-100"
                                style="background-color: #38BDF8; color: white; border-radius: 30px;">
                                Buat Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Update total harga otomatis
        const hargaSatuan = {{ $produk['harga'] }};
        document.getElementById('kuantitas').addEventListener('input', function() {
            const qty = parseInt(this.value) || 1;
            const total = hargaSatuan * qty;
            document.getElementById('totalHarga').innerText = total.toLocaleString('id-ID');
        });
    </script>
</body>

</html>
