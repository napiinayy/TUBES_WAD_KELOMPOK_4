{{-- resources/views/aslab/pengadaan/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Pengadaan Barang</title>
    
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
                
                <!-- Breadcrumb -->
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/test-dashboard" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Beranda</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/test-pengadaan" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Pengadaan Barang</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah Pengadaan</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Pengajuan Pengadaan Barang</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="/test-pengadaan">
                        @csrf
                        
                        <!-- Detail Item Section -->
                        <div class="form-section">
                            <h3 class="section-title">Detail Item</h3>
                            
                            <!-- Kategori Barang -->
                            <div class="form-group">
                                <label for="id_kategori" class="form-label required">Kategori Barang</label>
                                <select class="form-control @error('id_kategori') is-invalid @enderror" 
                                        id="id_kategori" 
                                        name="id_kategori"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris ?? [] as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_barang }} - {{ $kategori->jenis_barang }}
                                        </option>
                                    @endforeach
                                    @if(!isset($kategoris) || count($kategoris) == 0)
                                        <option value="1">Mikroskop Digital - Alat Laboratorium</option>
                                        <option value="2">Beaker Glass 500ml - Peralatan Gelas</option>
                                        <option value="3">pH Meter Digital - Alat Ukur</option>
                                        <option value="4">Bunsen Burner - Alat Pemanas</option>
                                        <option value="5">Centrifuge - Alat Laboratorium</option>
                                    @endif
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Nama Item -->
                            <div class="form-group">
                                <label for="nama_barang" class="form-label required">Nama Item</label>
                                <input type="text" 
                                       class="form-control @error('nama_barang') is-invalid @enderror" 
                                       id="nama_barang" 
                                       name="nama_barang" 
                                       value="{{ old('nama_barang') }}"
                                       placeholder="Masukkan nama item"
                                       required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Spesifikasi -->
                            <div class="form-group">
                                <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                <textarea class="form-control @error('spesifikasi') is-invalid @enderror" 
                                          id="spesifikasi" 
                                          name="spesifikasi" 
                                          rows="3"
                                          placeholder="Masukkan spesifikasi item (opsional)">{{ old('spesifikasi') }}</textarea>
                                @error('spesifikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Form Row: Lab & Jumlah -->
                            <div class="form-row">
                                <!-- Nama Laboratorium -->
                                <div class="form-group">
                                    <label for="id_lab" class="form-label required">Nama Laboratorium</label>
                                    <select class="form-control @error('id_lab') is-invalid @enderror" 
                                            id="id_lab" 
                                            name="id_lab"
                                            required>
                                        <option value="">Pilih Laboratorium</option>
                                        @foreach($labs ?? [] as $lab)
                                            <option value="{{ $lab->id }}" {{ old('id_lab') == $lab->id ? 'selected' : '' }}>
                                                {{ $lab->nama_lab }}
                                            </option>
                                        @endforeach
                                        @if(!isset($labs) || count($labs) == 0)
                                            <option value="1">Lab Kimia</option>
                                            <option value="2">Lab Fisika</option>
                                            <option value="3">Lab Biologi</option>
                                            <option value="4">Lab Komputer</option>
                                        @endif
                                    </select>
                                    @error('id_lab')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Jumlah -->
                                <div class="form-group">
                                    <label for="jumlah" class="form-label required">Jumlah</label>
                                    <input type="number" 
                                           class="form-control @error('jumlah') is-invalid @enderror" 
                                           id="jumlah" 
                                           name="jumlah" 
                                           value="{{ old('jumlah', 1) }}"
                                           min="1"
                                           placeholder="Masukkan jumlah"
                                           required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Alasan Pengajuan Section -->
                        <div class="form-section">
                            <h3 class="section-title">Alasan Pengajuan</h3>
                            
                            <div class="form-group">
                                <label for="alasan_pengadaan" class="form-label required">Alasan Pengajuan Barang</label>
                                <textarea class="form-control @error('alasan_pengadaan') is-invalid @enderror" 
                                          id="alasan_pengadaan" 
                                          name="alasan_pengadaan" 
                                          rows="5"
                                          placeholder="Jelaskan mengapa barang ini dibutuhkan"
                                          required>{{ old('alasan_pengadaan') }}</textarea>
                                @error('alasan_pengadaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="/test-pengadaan" class="btn btn-secondary">Kembali</a>
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