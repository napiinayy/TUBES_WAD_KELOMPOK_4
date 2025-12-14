{{-- resources/views/aslab/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Asisten Laboratorium</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="nav-container">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/test-dashboard">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-pengadaan">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-peminjaman">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-keluhan">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-kategori">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-profil">Profil</a>
                    </li>
                </ul>
            </div>
            
            <div class="sidebar-footer">
                <p class="version-info">LabMan v2.4.0</p>
                <p class="copyright">© 2023 Science Dept.</p>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <h1 class="welcome-title" style="color: white; font-size: 2rem; font-weight: bold; margin-bottom: 32px;">
                    Selamat Datang
                </h1>
                
                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <a href="/test-pengadaan" class="text-decoration-none">
                            <div class="stat-card">
                                <div class="stat-title">Pengadaan Barang</div>
                                <div class="stat-value">{{ $pengadaanCount ?? 0 }}</div>
                                <img src="https://via.placeholder.com/50x50/08A045/ffffff?text=P" alt="Icon" class="stat-icon">
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <a href="/test-peminjaman" class="text-decoration-none">
                            <div class="stat-card">
                                <div class="stat-title">Peminjaman Barang</div>
                                <div class="stat-value">{{ $peminjamanCount ?? 12 }}</div>
                                <img src="https://via.placeholder.com/50x50/08A045/ffffff?text=PM" alt="Icon" class="stat-icon">
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <div class="stat-card">
                            <div class="stat-title">Keluhan</div>
                            <div class="stat-value">{{ $keluhanCount ?? 1 }}</div>
                            <img src="https://via.placeholder.com/50x50/08A045/ffffff?text=K" alt="Icon" class="stat-icon">
                        </div>
                    </div>
                </div>
                
                <!-- Pengajuan Barang Table -->
                <div class="table-section">
                    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3>Pengajuan Barang</h3>
                        <a href="/test-pengadaan" class="btn btn-sm btn-primary" style="font-size: 0.875rem; padding: 8px 16px;">
                            Lihat Semua
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-container with-header">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"><div class="form-check"><input class="form-check-input" type="checkbox" id="selectAllPengajuan"></div></th>
                                        <th style="width: 12%;">ID Permintaan</th>
                                        <th style="width: 20%;">Detail Barang</th>
                                        <th style="width: 15%;">Pengaju</th>
                                        <th style="width: 13%;">Tanggal</th>
                                        <th style="width: 10%;">Jumlah</th>
                                        <th style="width: 12%;">Status</th>
                                        <th style="width: 13%;" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#REQ-2048</span></td>
                                        <td><div class="item-name">Digital Centrifuge</div></td>
                                        <td>
                                            <div class="submitter-name">John Smith</div>
                                            <div class="submitter-dept">Chemistry</div>
                                        </td>
                                        <td><span class="date-text">Oct 23, 2023</span></td>
                                        <td><span class="quantity-badge">1</span></td>
                                        <td><span class="badge badge-approved">Approved</span></td>
                                        <td class="text-end">
                                            <a href="/test-pengadaan/2048" class="action-btn"><i class="bi bi-eye"></i></a>
                                            <a href="/test-pengadaan/2048/edit" class="action-btn"><i class="bi bi-pencil"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#REQ-2047</span></td>
                                        <td><div class="item-name">Beaker Set (500ml)</div></td>
                                        <td>
                                            <div class="submitter-name">Alice Wong</div>
                                            <div class="submitter-dept">Physics</div>
                                        </td>
                                        <td><span class="date-text">Oct 22, 2023</span></td>
                                        <td><span class="quantity-badge">2</span></td>
                                        <td><span class="badge badge-rejected">Rejected</span></td>
                                        <td class="text-end">
                                            <a href="/test-pengadaan/2047" class="action-btn"><i class="bi bi-eye"></i></a>
                                            <a href="/test-pengadaan/2047/edit" class="action-btn"><i class="bi bi-pencil"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#REQ-2046</span></td>
                                        <td><div class="item-name">Bunsen Burners (x5)</div></td>
                                        <td>
                                            <div class="submitter-name">Bob Brown</div>
                                            <div class="submitter-dept">Chemistry</div>
                                        </td>
                                        <td><span class="date-text">Oct 21, 2023</span></td>
                                        <td><span class="quantity-badge">1</span></td>
                                        <td><span class="badge badge-pending">Pending</span></td>
                                        <td class="text-end">
                                            <a href="/test-pengadaan/2046" class="action-btn"><i class="bi bi-eye"></i></a>
                                            <a href="/test-pengadaan/2046/edit" class="action-btn"><i class="bi bi-pencil"></i></a>
                                            <button class="action-btn"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Peminjaman Barang Table -->
                <div class="table-section">
                    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3>Peminjaman Barang</h3>
                        <a href="/test-peminjaman" class="btn btn-sm btn-primary" style="font-size: 0.875rem; padding: 8px 16px;">
                            Lihat Semua
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-container with-header">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"><div class="form-check"><input class="form-check-input" type="checkbox" id="selectAllPeminjaman"></div></th>
                                        <th style="width: 10%;">ID Peminjaman</th>
                                        <th style="width: 18%;">Nama Barang</th>
                                        <th style="width: 12%;">Peminjam</th>
                                        <th style="width: 8%;">Kelas</th>
                                        <th style="width: 11%;">Tanggal Pinjam</th>
                                        <th style="width: 11%;">Tanggal Kembali</th>
                                        <th style="width: 8%;">Jumlah</th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 7%;" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#BRW-1025</span></td>
                                        <td><div class="item-name">Microscope Olympus CX23</div></td>
                                        <td>
                                            <div class="borrower-name">Emma Wilson</div>
                                            <div class="borrower-dept">Biology</div>
                                        </td>
                                        <td><span class="date-text">XII-A</span></td>
                                        <td><span class="date-text">Oct 20, 2023</span></td>
                                        <td><span class="date-text">Oct 27, 2023</span></td>
                                        <td><span class="quantity-badge">1</span></td>
                                        <td><span class="badge badge-dipinjam">Dipinjam</span></td>
                                        <td class="text-end">
                                            <a href="/test-peminjaman/1025" class="action-btn"><i class="bi bi-eye"></i></a>
                                            <a href="/test-peminjaman/1025/edit" class="action-btn"><i class="bi bi-check-circle"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#BRW-1024</span></td>
                                        <td><div class="item-name">Lab Coat (Size L)</div></td>
                                        <td>
                                            <div class="borrower-name">Michael Chen</div>
                                            <div class="borrower-dept">Chemistry</div>
                                        </td>
                                        <td><span class="date-text">XI-B</span></td>
                                        <td><span class="date-text">Oct 18, 2023</span></td>
                                        <td><span class="date-text">Oct 25, 2023</span></td>
                                        <td><span class="quantity-badge">2</span></td>
                                        <td><span class="badge badge-dipinjam">Dipinjam</span></td>
                                        <td class="text-end">
                                            <a href="/test-peminjaman/1024" class="action-btn"><i class="bi bi-eye"></i></a>
                                            <a href="/test-peminjaman/1024/edit" class="action-btn"><i class="bi bi-check-circle"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#BRW-1023</span></td>
                                        <td><div class="item-name">pH Meter Digital</div></td>
                                        <td>
                                            <div class="borrower-name">Lisa Anderson</div>
                                            <div class="borrower-dept">Chemistry</div>
                                        </td>
                                        <td><span class="date-text">X-C</span></td>
                                        <td><span class="date-text">Oct 15, 2023</span></td>
                                        <td><span class="date-text">Oct 22, 2023</span></td>
                                        <td><span class="quantity-badge">1</span></td>
                                        <td><span class="badge badge-terlambat">Terlambat</span></td>
                                        <td class="text-end">
                                            <a href="/test-peminjaman/1023" class="action-btn"><i class="bi bi-eye"></i></a>
                                            <a href="/test-peminjaman/1023/edit" class="action-btn"><i class="bi bi-exclamation-circle"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Select all checkboxes for Pengajuan Barang table
        document.getElementById('selectAllPengajuan')?.addEventListener('change', function() {
            const table = this.closest('table');
            const checkboxes = table.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        // Select all checkboxes for Peminjaman Barang table
        document.getElementById('selectAllPeminjaman')?.addEventListener('change', function() {
            const table = this.closest('table');
            const checkboxes = table.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
</body>
</html>