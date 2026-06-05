<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Admin - InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F7FC;
            color: #1E293B;
        }

        .sidebar-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 24px 16px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.02);
            border: none;
        }

        .sidebar-card .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #64748B;
            font-weight: 600;
            border-radius: 12px;
            margin-bottom: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-card .nav-link:hover {
            background-color: #F8FAFC;
            color: #0F172A;
        }

        .sidebar-card .nav-link.active {
            background-color: #EBF3FF;
            color: #2563EB;
        }

        .sidebar-card .nav-link i {
            font-size: 1.2rem;
        }

        .main-content {
            padding: 10px 20px 40px 20px;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 24px;
            text-transform: uppercase;
        }

        .table-card {
            background-color: #ffffff;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.03);
            border: none;
        }

        .search-box {
            position: relative;
            max-width: 250px;
        }

        .search-box .form-control {
            border: 1px solid #E2E8F0;
            border-radius: 50px;
            padding: 10px 40px 10px 20px;
            font-size: 0.9rem;
            color: #0F172A;
            outline: none;
            box-shadow: none;
            transition: all 0.2s ease;
        }

        .search-box .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-box .search-icon {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 1rem;
        }

        .table thead th {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1E293B;
            border-bottom: 2px solid #E2E8F0;
            padding-bottom: 16px;
        }

        .table tbody td {
            font-size: 0.95rem;
            color: #475569;
            padding: 16px 8px;
            border-bottom: 1px solid #F1F5F9;
        }

        /* Status badge styles */
        .status-badge-custom {
            display: inline-block;
            font-size: 0.8rem;
            padding: 6px 16px;
            font-weight: 600;
            border-radius: 50px;
        }

        .btn-edit {
            background-color: #38BDF8;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-edit:hover {
            background-color: #0ea5e9;
        }

        .btn-receipt {
            background-color: #10B981;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-receipt:hover {
            background-color: #059669;
            color: white;
        }

        .btn-simpan {
            background-color: #2563EB;
            color: white;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 700;
            border: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            transition: all 0.2s ease;
        }

        .btn-simpan:hover {
            background-color: #1D4ED8;
            color: white;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
        }

        .custom-dropdown {
            position: relative;
            width: 100%;
        }

        .custom-dropdown-toggle {
            background-color: white;
            border: 1px solid #CBD5E1;
            border-radius: 12px;
            padding: 12px 16px;
            width: 100%;
            text-align: left;
            position: relative;
            cursor: pointer;
            font-size: 0.95rem;
            color: #0F172A;
            transition: all 0.2s ease;
        }

        .custom-dropdown-toggle:hover {
            border-color: #2563EB;
        }

        .custom-dropdown-toggle i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748B;
            transition: transform 0.2s;
        }

        .custom-dropdown-toggle.open i {
            transform: translateY(-50%) rotate(180deg);
        }

        .custom-dropdown-menu {
            position: absolute;
            top: 105%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            display: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            overflow: hidden;
            padding: 6px;
        }

        .custom-dropdown-menu.show {
            display: block;
        }

        .custom-dropdown-item {
            padding: 10px 16px;
            cursor: pointer;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #475569;
            transition: all 0.15s ease;
        }

        .custom-dropdown-item:hover {
            background-color: #F1F5F9;
            color: #0F172A;
        }

        .custom-dropdown-item.active {
            background-color: #EBF3FF;
            color: #2563EB;
            font-weight: 600;
        }

        .alert-success {
            background-color: #DCFCE7;
            color: #15803D;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .alert-danger {
            background-color: #FEE2E2;
            color: #B91C1C;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>
    @include('admin.partials.header')

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-4 col-lg-2 mb-4">
                <div class="sidebar-card">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.orders') }}">
                                <i class="bi bi-cart-fill"></i>
                                Pesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-8 col-lg-10 main-content">
                <h2 class="page-title">PESANAN</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-card">
                    <!-- Search Bar -->
                    <div class="d-flex justify-content-end mb-4">
                        <div class="search-box">
                            <input type="text" class="form-control" id="table-search" placeholder="Cari">
                            <i class="bi bi-search search-icon"></i>
                        </div>
                    </div>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table align-middle" id="orders-table">
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
                                        <td class="fw-semibold">#{{ $order['no_pesanan'] }}</td>
                                        <td>{{ $order['email_pembeli'] ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order['order_date'])->format('d-m-Y') }}</td>
                                        <td>
                                            @php
                                                $badgeStyle = match ($order['status']) {
                                                    'unpaid' => 'background-color: #F59E0B; color: #ffffff;',
                                                    'paid' => 'background-color: #2563EB; color: #ffffff;',
                                                    'process' => 'background-color: #0D95D2; color: #ffffff;',
                                                    'done' => 'background-color: #10B981; color: #ffffff;',
                                                    default => 'background-color: #64748B; color: #ffffff;',
                                                };

                                                $statusText = match ($order['status']) {
                                                    'unpaid' => 'Belum dibayar',
                                                    'paid' => 'Sudah dibayar',
                                                    'process' => 'Diproses',
                                                    'done' => 'Selesai',
                                                    default => $order['status'],
                                                };
                                            @endphp

                                            <span class="status-badge-custom"
                                                style="{{ $badgeStyle }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-edit" data-bs-toggle="modal"
                                                data-bs-target="#editStatusModal" data-order-id="{{ $order['id_pesanan'] }}"
                                                data-current-status="{{ $order['status'] }}">
                                                Edit
                                            </button>
                                            @if (isset($order['payment']) && !empty($order['payment']['image_path']))
                                                <a href="{{ route('admin.orders.receipt', basename($order['payment']['image_path'])) }}"
                                                    target="_blank" class="btn-receipt ms-2">
                                                    <i class="bi bi-file-earmark-text-fill"></i> Bukti
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
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
            <div class="modal-content rounded-4 shadow border-0">
                <div class="modal-body p-4">
                    <h4 class="fw-bold mb-3">Ubah Status</h4>
                    <label class="fw-semibold mb-2 text-secondary" style="font-size: 0.9rem;">Status Pesanan</label>

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
        document.addEventListener('DOMContentLoaded', function () {
            var editStatusModal = document.getElementById('editStatusModal');
            var customToggle = document.getElementById('customDropdownToggle');
            var customMenu = document.getElementById('customDropdownMenu');
            var selectedText = document.getElementById('selectedStatusText');
            var inputStatus = document.getElementById('inputStatus');
            var formUpdateStatus = document.getElementById('formUpdateStatus');

            editStatusModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute('data-order-id');
                var currentStatus = button.getAttribute('data-current-status');

                // Map value to display text
                var statusMap = {
                    'unpaid': 'Belum dibayar',
                    'paid': 'Sudah dibayar',
                    'process': 'Diproses',
                    'done': 'Selesai'
                };

                // Set teks dropdown
                var displayName = statusMap[currentStatus] || currentStatus;
                selectedText.textContent = displayName;
                inputStatus.value = currentStatus;

                // Tandai item yang aktif
                var items = customMenu.querySelectorAll('.custom-dropdown-item');
                items.forEach(function (item) {
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
            customToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                customMenu.classList.toggle('show');
                customToggle.classList.toggle('open');
            });

            // Pilih item dropdown
            customMenu.addEventListener('click', function (e) {
                var item = e.target.closest('.custom-dropdown-item');
                if (item) {
                    var value = item.getAttribute('data-value');
                    var text = item.textContent;
                    selectedText.textContent = text;
                    inputStatus.value = value;

                    var items = customMenu.querySelectorAll('.custom-dropdown-item');
                    items.forEach(function (el) {
                        el.classList.remove('active');
                    });
                    item.classList.add('active');

                    customMenu.classList.remove('show');
                    customToggle.classList.remove('open');
                }
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', function (e) {
                if (!customToggle.contains(e.target) && !customMenu.contains(e.target)) {
                    customMenu.classList.remove('show');
                    customToggle.classList.remove('open');
                }
            });

            // Client-side search filtering
            const searchInput = document.getElementById('table-search');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const query = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#orders-table tbody tr');

                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length > 1) { // Skip empty state row
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(query) ? '' : 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>