<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Admin - InkSpire</title>
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

        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .search-box {
            position: relative;
            max-width: 250px;
        }

        .search-box .form-control {
            border-color: #38BDF8;
            border-radius: 20px;
            padding-right: 35px;
        }

        .search-box .search-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .table thead th {
            font-weight: 700;
            border-bottom: 2px solid #dee2e6;
        }

        .btn-edit {
            background-color: #38BDF8;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 5px 15px;
            font-size: 0.9rem;
        }

        .btn-edit:hover {
            background-color: #0ea5e9;
        }

        .btn-simpan {
            background-color: #38BDF8;
            color: white;
            border-radius: 12px;
            padding: 10px 25px;
            border: none;
        }

        .btn-simpan:hover {
            background-color: #0ea5e9;
        }

        .custom-dropdown {
            position: relative;
            width: 100%;
        }

        .custom-dropdown-toggle {
            background-color: white;
            border: 2px solid #38BDF8;
            border-radius: 8px;
            padding: 8px 15px;
            width: 100%;
            text-align: left;
            position: relative;
            cursor: pointer;
        }

        .custom-dropdown-toggle i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0D95D2;
            transition: transform 0.2s;
        }

        .custom-dropdown-toggle.open i {
            transform: translateY(-50%) rotate(180deg);
        }

        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #38BDF8;
            border-top: none;
            border-radius: 0 0 8px 8px;
            display: none;
            z-index: 1000;
        }

        .custom-dropdown-menu.show {
            display: block;
        }

        .custom-dropdown-item {
            padding: 8px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.1s;
        }

        .custom-dropdown-item:last-child {
            border-bottom: none;
        }

        .custom-dropdown-item:hover {
            background-color: #F0F9FF;
        }

        .custom-dropdown-item.active {
            background-color: #E6F4FE;
            color: #0D95D2;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <!-- Header Admin -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0D95D2;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white fw-bold mb-0" href="#">InkSpire</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm"
                    style="background-color: white; color: #0D95D2; border-radius: 20px;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders') }}"> <i class="bi bi-grid-fill"></i>
                            Dashboard
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.orders') }}">
                            <i class="bi bi-cart-fill"></i>
                            Pesanan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2 class="fw-bold mb-4">PESANAN</h2>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-card">
                    <!-- Search Bar -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="search-box">
                            <input type="text" class="form-control" placeholder="Cari">
                            <i class="bi bi-search search-icon"></i>
                        </div>
                    </div>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Nama Pemesan</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>#{{ $order['no_pesanan'] }}</td>
                                        <td>{{ $order['email_pembeli'] ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order['order_date'])->format('d-m-Y') }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match ($order['status']) {
                                                    'unpaid' => 'bg-warning text-dark',
                                                    'paid' => 'bg-primary',
                                                    'process' => 'bg-info',
                                                    'done' => 'bg-success',
                                                    default => 'bg-secondary',
                                                };

                                                $statusText = match ($order['status']) {
                                                    'unpaid' => 'Belum dibayar',
                                                    'paid' => 'Sudah dibayar',
                                                    'process' => 'Diproses',
                                                    'done' => 'Selesai',
                                                    default => $order[
                                                        'status'
                                                    ], // fallback ke teks asli jika status tidak dikenali
                                                };
                                            @endphp

                                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-edit" data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal"
                                                data-order-id="{{ $order['id_pesanan'] }}"
                                                data-current-status="{{ $order['status'] }}">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-inbox display-4 text-muted"></i>
                                            <p class="mt-2 mb-0">Belum ada pesanan aktif.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Status -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-body p-4">
                    <h4 class="fw-bold mb-3">Ubah Status</h4>
                    <label class="fw-semibold mb-2">Status Pesanan</label>

                    <form id="formUpdateStatus" method="POST" action="">
                        @csrf
                        @method('PUT')

                        <div class="custom-dropdown" id="customStatusDropdown">
                            <div class="custom-dropdown-toggle" id="customDropdownToggle">
                                <span id="selectedStatusText">Belum dibayar</span>
                                <i class="bi bi-chevron-down"></i>
                            </div>
                            <div class="custom-dropdown-menu" id="customDropdownMenu">
                                <div class="custom-dropdown-item" data-value="unpaid">Belum dibayar</div>
                                <div class="custom-dropdown-item" data-value="paid">Sudah dibayar</div>
                                <div class="custom-dropdown-item" data-value="process">Diproses</div>
                                <div class="custom-dropdown-item" data-value="done">Selesai</div>
                            </div>
                        </div>

                        <!-- Input hidden untuk menyimpan status yang dipilih -->
                        <input type="hidden" name="status" id="inputStatus" value="">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-simpan w-100" id="btnSimpanStatus">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editStatusModal = document.getElementById('editStatusModal');
            var customToggle = document.getElementById('customDropdownToggle');
            var customMenu = document.getElementById('customDropdownMenu');
            var selectedText = document.getElementById('selectedStatusText');
            var inputStatus = document.getElementById('inputStatus');
            var formUpdateStatus = document.getElementById('formUpdateStatus');

            editStatusModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute('data-order-id');
                var currentStatus = button.getAttribute('data-current-status');

                // Set teks dropdown
                selectedText.textContent = currentStatus;
                inputStatus.value = currentStatus;

                // Tandai item yang aktif
                var items = customMenu.querySelectorAll('.custom-dropdown-item');
                items.forEach(function(item) {
                    item.classList.remove('active');
                    if (item.getAttribute('data-value') === currentStatus) {
                        item.classList.add('active');
                    }
                });

                // Set action form
                formUpdateStatus.action = '/admin/orders/' + orderId + '/status';

                // Pastikan dropdown tertutup
                customMenu.classList.remove('show');
                customToggle.classList.remove('open');
            });

            // Toggle dropdown
            customToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                customMenu.classList.toggle('show');
                customToggle.classList.toggle('open');
            });

            // Pilih item dropdown
            customMenu.addEventListener('click', function(e) {
                var item = e.target.closest('.custom-dropdown-item');
                if (item) {
                    var value = item.getAttribute('data-value');
                    selectedText.textContent = value;
                    inputStatus.value = value;

                    var items = customMenu.querySelectorAll('.custom-dropdown-item');
                    items.forEach(function(el) {
                        el.classList.remove('active');
                    });
                    item.classList.add('active');

                    customMenu.classList.remove('show');
                    customToggle.classList.remove('open');
                }
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', function(e) {
                if (!customToggle.contains(e.target) && !customMenu.contains(e.target)) {
                    customMenu.classList.remove('show');
                    customToggle.classList.remove('open');
                }
            });
        });
    </script>
</body>

</html>
