{{-- resources/views/aslab/pengadaan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengadaan Barang</title>
    
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
                        <a class="nav-link" href="/test-dashboard">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/test-pengadaan">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-peminjaman">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profil</a>
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
                <!-- Breadcrumb -->
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/test-dashboard" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active">Pengadaan Barang</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Daftar Pengadaan Barang</h1>
                </div>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Table Section -->
                <div class="table-section-full">
                    <div class="table-header-actions">
                        <h3>Pengajuan Barang</h3>
                        <a href="/test-pengadaan/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Pengadaan
                        </a>
                    </div>
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"><div class="form-check"><input class="form-check-input" type="checkbox" id="selectAll"></div></th>
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
                                    @forelse($pengadaans ?? [] as $pengadaan)
                                    <tr>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                                        <td><span class="req-id">#REQ-{{ str_pad($pengadaan->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td><div class="item-name">{{ $pengadaan->nama_barang }}</div></td>
                                        <td>
                                            <div class="submitter-name">{{ $pengadaan->pengaju ?? 'Admin' }}</div>
                                            <div class="submitter-dept">{{ $pengadaan->lab->nama_lab ?? 'N/A' }}</div>
                                        </td>
                                        <td><span class="date-text">{{ $pengadaan->created_at->format('M d, Y') }}</span></td>
                                        <td><span class="quantity-badge">{{ $pengadaan->jumlah }}</span></td>
                                        <td><span class="badge badge-{{ strtolower($pengadaan->status ?? 'pending') }}">{{ ucfirst($pengadaan->status ?? 'Pending') }}</span></td>
                                        <td class="text-end">
                                            <a href="/test-pengadaan/{{ $pengadaan->id }}" class="action-btn" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/test-pengadaan/{{ $pengadaan->id }}/edit" class="action-btn" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="action-btn" title="Delete" onclick="confirmDelete({{ $pengadaan->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada data pengadaan barang</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
    
    <!-- Delete Form (hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    
    <script>
        // Select all checkboxes
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        // Confirm delete
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = '/test-pengadaan/' + id;
                form.submit();
            }
        }
    </script>
</body>
</html>