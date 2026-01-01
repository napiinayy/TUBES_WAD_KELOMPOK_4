{{-- resources/views/aslab/pengadaan/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengadaan Barang</title>
    
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
                        <a class="nav-link active" href="{{ route('aslab.pengadaan.index') }}">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.peminjaman.index') }}">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.keluhan.index') }}">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.barang.index') }}">Katalog Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">Profil</a>
                    </li>
                </ul>
            </div>
            
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" style="margin-bottom: 16px;">
                    @csrf
                    <button type="submit" class="nav-link logout-btn" style="width: 100%; text-align: left; background: transparent; border: 1px solid #08A045; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
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
                                <a href="{{ route('aslab.pengadaan.index') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Pengadaan Barang</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Detail Pengadaan Barang</h1>
                </div>
                
                <!-- Detail Card -->
                <div class="detail-card">
                    <!-- Detail Header -->
                    <div class="detail-header">
                        <div>
                            <h2 class="detail-id">#REQ-{{ str_pad($pengadaan->id, 4, '0', STR_PAD_LEFT) }}</h2>
                            <p class="detail-date">Dibuat: {{ $pengadaan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="badge badge-{{ strtolower($pengadaan->status) }} badge-lg">
                            {{ ucfirst($pengadaan->status) }}
                        </span>
                    </div>
                    
                    <!-- Detail Content -->
                    <div class="detail-section">
                        <h3 class="section-title">Informasi Barang</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Nama Barang</label>
                                <p class="detail-value">{{ $pengadaan->nama_barang }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Laboratorium</label>
                                <p class="detail-value">{{ $pengadaan->lab->nama_lab }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Jumlah</label>
                                <p class="detail-value">{{ $pengadaan->jumlah }} unit</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Pengaju</label>
                                <p class="detail-value">{{ $pengadaan->pengaju }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($pengadaan->spesifikasi)
                    <div class="detail-section">
                        <h3 class="section-title">Spesifikasi</h3>
                        <p class="detail-text">{{ $pengadaan->spesifikasi }}</p>
                    </div>
                    @endif
                    
                    <div class="detail-section">
                        <h3 class="section-title">Alasan Pengadaan</h3>
                        <p class="detail-text">{{ $pengadaan->alasan_pengadaan }}</p>
                    </div>
                    
                    <!-- Detail Footer -->
                    <div class="detail-footer">
                        <a href="{{ route('aslab.pengadaan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <div class="detail-actions">
                            <a href="{{ route('aslab.pengadaan.edit', $pengadaan->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $pengadaan->id }})">
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
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const form = document.getElementById('deleteForm');
                const baseUrl = '{{ route("aslab.pengadaan.destroy", ":id") }}';
                form.action = baseUrl.replace(':id', id);
                form.submit();
            }
        }
    </script>
</body>
</html>