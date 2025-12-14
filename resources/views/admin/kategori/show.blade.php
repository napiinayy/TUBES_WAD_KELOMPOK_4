{{-- resources/views/admin/kategori/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori Barang - Admin</title>
    
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
                        <a class="nav-link" href="/test-admin/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-admin/users">Kelola Profil Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/test-admin/kategori">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/test-admin/profil">Profil</a>
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
                                <a href="/test-admin/dashboard" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/test-admin/kategori" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Kategori Barang</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Detail Kategori Barang</h1>
                </div>
                
                <!-- Detail Card -->
                <div class="detail-card">
                    <!-- Detail Header -->
                    <div class="detail-header">
                        <div>
                            <h2 class="detail-id">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</h2>
                            <p class="detail-date">Dibuat: {{ $item->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="badge badge-approved badge-lg">
                            Active
                        </span>
                    </div>
                    
                    <!-- Detail Content -->
                    <div class="detail-section">
                        <h3 class="section-title">Informasi Barang</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">ID Barang</label>
                                <p class="detail-value">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Jenis Barang</label>
                                <p class="detail-value">{{ $item->jenis_barang }}</p>
                            </div>
                            <div class="detail-item" style="grid-column: 1 / -1;">
                                <label class="detail-label">Nama Barang</label>
                                <p class="detail-value">{{ $item->nama_barang }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Usage Statistics (Optional) -->
                    <div class="detail-section">
                        <h3 class="section-title">Statistik Penggunaan</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Total Pengadaan</label>
                                <p class="detail-value">{{ $item->total_pengadaan ?? 0 }} kali</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Total Peminjaman</label>
                                <p class="detail-value">{{ $item->total_peminjaman ?? 0 }} kali</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Terakhir Digunakan</label>
                                <p class="detail-value">{{ $item->last_used ? $item->last_used->format('d M Y') : '-' }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Status</label>
                                <p class="detail-value"><span class="badge badge-approved">Aktif</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Footer -->
                    <div class="detail-footer">
                        <a href="/test-admin/kategori" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <div class="detail-actions">
                            <a href="/test-admin/kategori/{{ $item->id }}/edit" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $item->id }})">
                                <i class="bi bi-trash me-2"></i>
                                Hapus
                            </button>
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
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus barang ini?\n\nPeringatan: Semua data terkait akan ikut terhapus.')) {
                const form = document.getElementById('deleteForm');
                form.action = '/test-admin/kategori/' + id;
                form.submit();
            }
        }
    </script>
</body>
</html>