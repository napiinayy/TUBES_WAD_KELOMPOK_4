{{-- resources/views/aslab/peminjaman/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman Barang</title>
    
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
                        <a class="nav-link" href="{{ route('admin.users.edit', auth()->id()) }}">Profil</a>
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
                                <a href="{{ route('peminjaman.index') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Peminjaman Barang</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Detail Peminjaman Barang</h1>
                </div>
                
                <!-- Detail Card -->
                <div class="detail-card">
                    <!-- Detail Header -->
                    <div class="detail-header">
                        <div>
                            <h2 class="detail-id">#BRW-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}</h2>
                            <p class="detail-date">Peminjam: {{ $peminjaman->user->nama_lengkap ?? 'User' }}</p>
                        </div>
                        <span class="badge badge-{{ strtolower($peminjaman->status) }} badge-lg">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                    
                    <!-- Detail Content -->
                    <div class="detail-section">
                        <h3 class="section-title">Informasi Barang</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Nama Barang</label>
                                <p class="detail-value">{{ $peminjaman->nama_barang }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Laboratorium</label>
                                <p class="detail-value">{{ $peminjaman->lab->nama_lab }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Kelas</label>
                                <p class="detail-value">{{ $peminjaman->kelas }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Jumlah</label>
                                <p class="detail-value">{{ $peminjaman->jumlah }} unit</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="section-title">Jadwal Peminjaman</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Tanggal Pinjam</label>
                                <p class="detail-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Tanggal Kembali</label>
                                <p class="detail-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Durasi Peminjaman</label>
                                <p class="detail-value">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_kembali)) }} hari
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="section-title">Alasan Peminjaman</h3>
                        <p class="detail-text">{{ $peminjaman->alasan_peminjaman }}</p>
                    </div>
                    
                    <!-- Detail Footer -->
                    <div class="detail-footer">
                        <a href="/test-peminjaman" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <div class="detail-actions">
                            <a href="/test-peminjaman/{{ $peminjaman->id }}/edit" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $peminjaman->id }})">
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
                const baseUrl = '{{ route("peminjaman.destroy", ":id") }}';
                form.action = baseUrl.replace(':id', id);
                form.submit();
            }
        }
    </script>
</body>
</html>