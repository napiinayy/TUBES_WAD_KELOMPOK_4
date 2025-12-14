{{-- resources/views/aslab/peminjaman/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Peminjaman Barang</title>
    
    <!-- Google Fonts - Space Grotesk -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Compiled CSS -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="nav-container">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/home">
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/aslab/pengadaan">
                            Pengadaan Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/aslab/peminjaman">
                            Peminjaman Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Keluhan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Kategori Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Profil
                        </a>
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
                                <a href="/home" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active">Peminjaman Barang</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Pengajuan Peminjaman Barang</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="#">
                        @csrf
                        
                        <!-- Detail Item Section -->
                        <div class="form-section">
                            <h3 class="section-title">Detail Item</h3>
                            
                            <!-- Nama Item -->
                            <div class="form-group">
                                <label for="nama_barang" class="form-label required">
                                    Nama Item
                                </label>
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
                            
                            <!-- Nama Laboratorium -->
                            <div class="form-group">
                                <label for="id_lab" class="form-label">Nama Laboratorium</label>
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
                            
                            <!-- Form Row: Kelas & Jumlah -->
                            <div class="form-row">
                                <!-- Kelas -->
                                <div class="form-group">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" 
                                           class="form-control @error('kelas') is-invalid @enderror" 
                                           id="kelas" 
                                           name="kelas" 
                                           value="{{ old('kelas') }}"
                                           placeholder="Masukkan kelas"
                                           required>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Jumlah -->
                                <div class="form-group">
                                    <label for="jumlah" class="form-label">Jumlah</label>
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
                            
                            <!-- Form Row: Tanggal Pinjam & Tanggal Kembali -->
                            <div class="form-row">
                                <!-- Tanggal Pinjam -->
                                <div class="form-group">
                                    <label for="tanggal_pinjam" class="form-label required">Tanggal Pinjam</label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                           id="tanggal_pinjam" 
                                           name="tanggal_pinjam" 
                                           value="{{ old('tanggal_pinjam') }}"
                                           required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Tanggal Kembali -->
                                <div class="form-group">
                                    <label for="tanggal_kembali" class="form-label required">Tanggal Kembali</label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                           id="tanggal_kembali" 
                                           name="tanggal_kembali" 
                                           value="{{ old('tanggal_kembali') }}"
                                           required>
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Alasan Peminjaman Section -->
                        <div class="form-section">
                            <h3 class="section-title">Alasan Peminjaman</h3>
                            
                            <div class="form-group">
                                <label for="alasan_peminjaman" class="form-label required">
                                    Alasan Peminjaman Barang
                                </label>
                                <textarea class="form-control @error('alasan_peminjaman') is-invalid @enderror" 
                                          id="alasan_peminjaman" 
                                          name="alasan_peminjaman" 
                                          rows="5"
                                          placeholder="Jelaskan mengapa barang ini dibutuhkan"
                                          required>{{ old('alasan_peminjaman') }}</textarea>
                                @error('alasan_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="/home" class="btn btn-secondary">
                                Kembali
                            </a>
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
        
        // Validate return date is after borrow date
        document.getElementById('tanggal_kembali')?.addEventListener('change', function() {
            const borrowDate = document.getElementById('tanggal_pinjam').value;
            const returnDate = this.value;
            
            if (borrowDate && returnDate && returnDate < borrowDate) {
                alert('Tanggal kembali harus setelah tanggal pinjam');
                this.value = '';
            }
        });
    </script>
</body>
</html>