{{-- resources/views/admin/users/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna - Admin</title>
    
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
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                        {{-- Admin Sidebar --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $user->id == auth()->id() ? '' : 'active' }}" href="{{ route('admin.users.index') }}">Kelola Profil Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.barang.index') }}">Daftar Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.kategoris.index') }}">Kelola Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.keluhan.index') }}">Keluhan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $user->id == auth()->id() ? 'active' : '' }}" href="{{ route('profile') }}">Profil</a>
                        </li>
                    @else
                        {{-- Aslab Sidebar --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('aslab.pengadaan.index') }}">Pengadaan Barang</a>
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
                            <a class="nav-link active" href="{{ route('profile') }}">Profil</a>
                        </li>
                    @endif
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
                                <a href="{{ route('home') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">
                                    {{ auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin' ? 'Dashboard' : 'Beranda' }}
                                </a>
                            </li>
                            @if($user->id != auth()->id())
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.users.index') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Kelola Profil Pengguna</a>
                            </li>
                            @endif
                            <li class="breadcrumb-item active">{{ $user->id == auth()->id() ? 'Profil Saya' : 'Detail Pengguna' }}</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>{{ $user->id == auth()->id() ? 'Profil Saya' : 'Detail Pengguna' }}</h1>
                </div>
                
                <!-- Detail Card -->
                <div class="detail-card">
                    <!-- Detail Header -->
                    <div class="detail-header">
                        <div>
                            <h2 class="detail-id">{{ $user->kode_aslab }}</h2>
                            <p class="detail-date">Terdaftar: {{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="badge badge-approved badge-lg">
                            Active
                        </span>
                    </div>
                    
                    <!-- Detail Content -->
                    <div class="detail-section">
                        <h3 class="section-title">Informasi Pribadi</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Nama Lengkap</label>
                                <p class="detail-value">{{ $user->nama_lengkap }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Kode Asisten Laboratorium</label>
                                <p class="detail-value">{{ $user->kode_aslab }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Email</label>
                                <p class="detail-value">{{ $user->email ?? '-' }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Username</label>
                                <p class="detail-value">{{ $user->username ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="section-title">Informasi Akademik</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Laboratorium</label>
                                <p class="detail-value">{{ $user->lab_name ?? '-' }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Jurusan</label>
                                <p class="detail-value">{{ $user->jurusan ?? '-' }}</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Role</label>
                                <p class="detail-value"><span class="badge badge-approved">{{ ucfirst($user->role ?? 'Aslab') }}</span></p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Status</label>
                                <p class="detail-value"><span class="badge badge-approved">Aktif</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity Statistics -->
                    <div class="detail-section">
                        <h3 class="section-title">Statistik Aktivitas</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label class="detail-label">Total Pengadaan</label>
                                <p class="detail-value">{{ $user->total_pengadaan ?? 0 }} permintaan</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Total Peminjaman</label>
                                <p class="detail-value">{{ $user->total_peminjaman ?? 0 }} peminjaman</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Total Keluhan</label>
                                <p class="detail-value">{{ $user->total_keluhan ?? 0 }} laporan</p>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Terakhir Login</label>
                                <p class="detail-value">{{ $user->last_login ? $user->last_login->format('d M Y, H:i') : 'Belum pernah login' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Footer -->
                    <div class="detail-footer">
                        @if($user->id != auth()->id())
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali
                        </a>
                        @else
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali ke Dashboard
                        </a>
                        @endif
                        <div class="detail-actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>
                                Edit Profil
                            </a>
                            @if($user->id != auth()->id())
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $user->id }})">
                                <i class="bi bi-trash me-2"></i>
                                Hapus
                            </button>
                            @endif
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
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?\n\nPeringatan: Semua data terkait akan ikut terhapus.')) {
                const form = document.getElementById('deleteForm');
                const baseUrl = '{{ route("admin.users.destroy", ":id") }}';
                form.action = baseUrl.replace(':id', id);
                form.submit();
            }
        }
    </script>
</body>
</html>