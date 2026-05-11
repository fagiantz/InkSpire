<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - InkSpire</title>
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

        .sidebar {
            background-color: #fff;
            border-right: 2px solid #38BDF8;
            min-height: calc(100vh - 56px);
            padding: 30px 20px;
        }

        .sidebar .nav-link {
            color: #6c757d;
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link.active {
            background-color: #E6F4FE;
            color: #0D95D2;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
        }

        .main-content {
            background-color: #F8F9FA;
            padding: 30px;
        }

        .order-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            position: relative;
            /* agar tombol hapus bisa absolute */
        }

        .product-placeholder {
            background-color: #e9ecef;
            border-radius: 12px;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-detail {
            background-color: #38BDF8;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
        }

        .btn-detail:hover {
            background-color: #0ea5e9;
        }

        /* Style tambahan untuk edit dan hapus */
        .edit-qty {
            cursor: pointer;
            color: #0D95D2;
            font-size: 0.9rem;
            margin-left: 6px;
            vertical-align: middle;
        }

        .edit-qty:hover {
            color: #085a7c;
        }

        .qty-input {
            width: 60px;
            text-align: center;
            border: 1px solid #38BDF8;
            border-radius: 6px;
            padding: 2px 4px;
        }

        .btn-hapus {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .btn-hapus:hover {
            color: #a71d2a;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="bi bi-cart-fill"></i>
                            Pesanan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2 class="fw-bold mb-2">DASHBOARD</h2>
                <h5 class="fw-bold mb-3">Pesanan Aktif</h5>

                <!-- Kartu Pesanan Dummy (sekarang interaktif) -->
                @forelse ($orders as $order)
                    <div class="order-card d-flex flex-column flex-md-row align-items-md-center gap-3">
                        <!-- Tombol Hapus (opsional, bisa diaktifkan nanti) -->
                        <button class="btn-hapus" onclick="hapusPesanan('order-{{ $order['id_pesanan'] }}')"
                            title="Hapus pesanan"
                            style="position: absolute; top: 12px; right: 16px; background: none; border: none; color: #dc3545; font-size: 1.2rem; cursor: pointer;">
                            <i class="bi bi-trash-fill"></i>
                        </button>

                        <!-- Gambar Produk (placeholder, karena belum ada gambar di backend) -->
                        <div class="product-placeholder">
                            <i class="bi bi-image" style="font-size: 2.5rem; color: #38BDF8;"></i>
                        </div>

                        <!-- Detail Pesanan -->
                        <div class="flex-grow-1">
                            <h6 class="fw-bold">
                                @if (!empty($order['items']))
                                    @php $produk = $order['items'][0]; @endphp
                                    Produk ID: {{ $produk['id_produk'] ?? 'N/A' }}
                                @else
                                    Produk tidak diketahui
                                @endif
                            </h6>
                            <p class="mb-1">No. Pesanan: {{ $order['no_pesanan'] }}</p>
                            <p class="mb-1">Jumlah Item: {{ count($order['items'] ?? []) }}</p>
                            <p class="mb-0 text-muted">Status:
                                <span
                                    class="badge 
                    @if ($order['status'] == 'unpaid') bg-warning text-dark
                    @elseif($order['status'] == 'process') bg-info
                    @elseif($order['status'] == 'done') bg-success @endif">
                                    {{ $order['status'] }}
                                </span>
                            </p>
                        </div>

                        <!-- Total & Aksi -->
                        <div class="text-md-end">
                            <p class="fw-bold fs-5">Rp {{ number_format($order['total_harga'], 0, ',', '.') }}</p>
                            <a href="{{ route('orders.detail') }}" class="btn btn-detail">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="mt-3">Belum ada pesanan aktif.</p>
                        <a href="{{ route('katalog') }}" class="btn btn-primary"
                            style="background-color: #38BDF8; border: none;">Mulai Belanja</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simpan harga satuan di sini atau ambil dari data-attribute
        const hargaSatuan = {
            '1': 10000 // id pesanan -> harga satuan
        };

        function editJumlah(orderId, harga) {
            const displaySpan = document.getElementById(`qty-display-${orderId}`);
            const currentQty = parseInt(displaySpan.textContent);

            // Buat input field
            const input = document.createElement('input');
            input.type = 'number';
            input.min = 1;
            input.value = currentQty;
            input.className = 'qty-input';
            input.id = `qty-input-${orderId}`;

            // Ganti span dengan input
            displaySpan.replaceWith(input);
            input.focus();
            input.select();

            // Simpan saat kehilangan fokus atau tekan Enter
            const simpanPerubahan = () => {
                let newQty = parseInt(input.value);
                if (isNaN(newQty) || newQty < 1) {
                    newQty = 1; // minimal 1
                }
                // Kembalikan ke span dengan nilai baru
                const newSpan = document.createElement('span');
                newSpan.className = 'qty-display';
                newSpan.id = `qty-display-${orderId}`;
                newSpan.textContent = newQty;
                input.replaceWith(newSpan);

                // Update total
                const totalDisplay = document.getElementById(`total-display-${orderId}`);
                const totalBaru = harga * newQty;
                totalDisplay.textContent = `Rp. ${totalBaru.toLocaleString('id-ID')}`;

                // Di sini bisa ditambahkan panggilan API ke backend untuk menyimpan perubahan
            };

            input.addEventListener('blur', simpanPerubahan);
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    simpanPerubahan();
                }
            });
        }

        function hapusPesanan(orderId) {
            const card = document.getElementById(`order-${orderId}`);
            if (card && confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
                card.remove();
                // Di sini bisa ditambahkan panggilan API ke backend untuk menghapus
            }
        }
    </script>
</body>

</html>
