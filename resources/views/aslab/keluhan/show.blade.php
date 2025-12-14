{{-- resources/views/aslab/keluhan/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Keluhan</title>
    
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
                        <a class="nav-link" href="{{ route('peminjaman.index') }}">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.keluhan.index') }}">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.kategori.index') }}">Kategori Barang</a>
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.keluhan.index') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Keluhan</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Detail Keluhan</h1>
                </div>
                
                <!-- Detail Card -->
                <div class="detail-card">
                    <!-- Detail Header -->
                    <div class="detail-header">
                        <div>
                            <h2 class="detail-id">#KLH-{{ str_pad($keluhan->id, 4, '0', STR_PAD_LEFT) }}</h2>
                            <p class="detail-date">Dibuat: {{ $keluhan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="badge badge-{{ strtolower($keluhan->status) }} badge-lg">
                            {{ ucfirst($keluhan->status) }}
                        </span>
                    </div>
                    
                    <!-- Detail Content -->
                    <div class="detail-section">
                        <h3 class="section-title">Informasi Keluhan</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Nama Item</label>
                                <p class="detail-value">{{ $keluhan->nama_item }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Jenis Keluhan</label>
                                <p class="detail-value">{{ $keluhan->jenis_keluhan }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Pelapor</label>
                                <p class="detail-value">{{ $keluhan->pelapor }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Tanggal Laporan</label>
                                <p class="detail-value">{{ $keluhan->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="section-title">Deskripsi Keluhan</h3>
                        <p class="detail-text">{{ $keluhan->deskripsi_keluhan }}</p>
                    </div>
                    
                    <!-- Detail Footer -->
                    <div class="detail-footer">
                        <a href="keluhan" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <div class="detail-actions">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $keluhan->id }})">
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
            if (confirm('Apakah Anda yakin ingin menghapus keluhan ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = 'keluhan/' + id;
                form.submit();
            }
        }
    </script>
</body>
</html>