{{-- resources/views/aslab/peminjaman/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman Barang</title>
    
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
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.pengadaan.index') }}">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('peminjaman.index') }}">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.keluhan.index') }}">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.barang.index') }}">Katalog Barang</a>
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
                                <a href="{{ route('home') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active">Peminjaman Barang</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Daftar Peminjaman Barang</h1>
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
                        <h3>Peminjaman Barang</h3>
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Peminjaman
                        </a>
                    </div>
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
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
                                    @forelse($peminjamans ?? [] as $peminjaman)
                                    <tr>
                                        <td><span class="req-id">#BRW-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td><div class="item-name">{{ $peminjaman->nama_barang }}</div></td>
                                        <td>
                                            <div class="borrower-name">{{ $peminjaman->user->nama_lengkap ?? 'User' }}</div>
                                            <div class="borrower-dept">{{ $peminjaman->lab->nama_lab ?? 'N/A' }}</div>
                                        </td>
                                        <td><span class="date-text">{{ $peminjaman->kelas }}</span></td>
                                        <td><span class="date-text">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('M d, Y') }}</span></td>
                                        <td><span class="date-text">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('M d, Y') }}</span></td>
                                        <td><span class="quantity-badge">{{ $peminjaman->jumlah }}</span></td>
                                        <td><span class="badge badge-{{ strtolower($peminjaman->status ?? 'dipinjam') }}">{{ ucfirst($peminjaman->status ?? 'Dipinjam') }}</span></td>
                                        <td class="text-end">
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="action-btn" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="action-btn" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="action-btn" title="Delete" onclick="confirmDelete({{ $peminjaman->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada data peminjaman barang</p>
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
                const baseUrl = '{{ route("peminjaman.destroy", ":id") }}';
                form.action = baseUrl.replace(':id', id);
                form.submit();
            }
        }
    </script>
</body>
</html>