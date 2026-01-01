{{-- resources/views/aslab/keluhan/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Keluhan</title>
    
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
                        <a class="nav-link" href="{{ route('aslab.peminjaman.index') }}">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('aslab.keluhan.index') }}">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/kategori">Kategori Barang</a>
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
                            <li class="breadcrumb-item active">Pengajuan Keluhan</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Pengajuan Keluhan</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="{{ route('aslab.keluhan.store') }}">
                        @csrf
                        
                        <!-- Detail Keluhan Section -->
                        <div class="form-section">
                            <h3 class="section-title">Detail Keluhan</h3>
                            
                            <!-- Nama Item -->
                            <div class="form-group">
                                <label for="nama_item" class="form-label required">Nama Item</label>
                                <input type="text" 
                                       class="form-control @error('nama_item') is-invalid @enderror" 
                                       id="nama_item" 
                                       name="nama_item" 
                                       value="{{ old('nama_item') }}"
                                       placeholder="Masukkan nama item yang bermasalah"
                                       required>
                                @error('nama_item')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Jenis Keluhan -->
                            <div class="form-group">
                                <label for="jenis_keluhan" class="form-label required">Jenis Keluhan</label>
                                <select class="form-control @error('jenis_keluhan') is-invalid @enderror" 
                                        id="jenis_keluhan" 
                                        name="jenis_keluhan"
                                        required>
                                    <option value="">Pilih Jenis Keluhan</option>
                                    <option value="Kerusakan" {{ old('jenis_keluhan') == 'Kerusakan' ? 'selected' : '' }}>Kerusakan</option>
                                    <option value="Kehilangan" {{ old('jenis_keluhan') == 'Kehilangan' ? 'selected' : '' }}>Kehilangan</option>
                                    <option value="Keterlambatan" {{ old('jenis_keluhan') == 'Keterlambatan' ? 'selected' : '' }}>Keterlambatan</option>
                                    <option value="Kualitas" {{ old('jenis_keluhan') == 'Kualitas' ? 'selected' : '' }}>Kualitas</option>
                                    <option value="Lainnya" {{ old('jenis_keluhan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Penjelasan Keluhan Section -->
                        <div class="form-section">
                            <h3 class="section-title">Penjelasan Keluhan</h3>
                            
                            <div class="form-group">
                                <label for="deskripsi_keluhan" class="form-label required">Jelaskan Keluhan</label>
                                <textarea class="form-control @error('deskripsi_keluhan') is-invalid @enderror" 
                                          id="deskripsi_keluhan" 
                                          name="deskripsi_keluhan" 
                                          rows="5"
                                          placeholder="Jelaskan dengan detail keluhan terhadap Item"
                                          required>{{ old('deskripsi_keluhan') }}</textarea>
                                @error('deskripsi_keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="{{ route('aslab.keluhan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </main>
    </div>
    
    <script>
        // Form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('form')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>