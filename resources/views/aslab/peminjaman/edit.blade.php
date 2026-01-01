{{-- resources/views/aslab/peminjaman/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman Barang</title>
    
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
                        <a class="nav-link active" href="{{ route('aslab.peminjaman.index') }}">Peminjaman Barang</a>
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
                                <a href="{{ route('aslab.peminjaman.index') }}" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Peminjaman Barang</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Edit Peminjaman Barang</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="{{ route('aslab.peminjaman.update', $peminjaman->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Detail Item Section -->
                        <div class="form-section">
                            <h3 class="section-title">Detail Item</h3>
                            
                            <!-- Item dari Barang -->
                            <div class="form-group">
                                <label for="kategori_id" class="form-label required">Pilih Item</label>
                                <select 
                                    class="form-control @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" 
                                    name="kategori_id" 
                                    required>
                                    <option value="">Pilih Item</option>
                                    @foreach(($barangs ?? []) as $barang)
                                        <option value="{{ $barang->id }}" {{ old('kategori_id', $peminjaman->kategori_id) == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }} ({{ $barang->kategori->nama_kategori ?? 'Tanpa Kategori' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
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
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}" {{ old('id_lab', $peminjaman->id_lab) == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->nama_lab }}
                                        </option>
                                    @endforeach
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
                                           value="{{ old('kelas', $peminjaman->kelas) }}"
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
                                           value="{{ old('jumlah', $peminjaman->jumlah) }}"
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
                                           value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}"
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
                                           value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}"
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
                                <label for="alasan_peminjaman" class="form-label required">Alasan Peminjaman Barang</label>
                                <textarea class="form-control @error('alasan_peminjaman') is-invalid @enderror" 
                                          id="alasan_peminjaman" 
                                          name="alasan_peminjaman" 
                                          rows="5"
                                          placeholder="Jelaskan mengapa barang ini dibutuhkan"
                                          required>{{ old('alasan_peminjaman', $peminjaman->alasan_peminjaman ?? '') }}</textarea>
                                @error('alasan_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="{{ route('aslab.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Simpan Perubahan
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