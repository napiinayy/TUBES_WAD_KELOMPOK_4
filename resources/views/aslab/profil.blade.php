{{-- resources/views/aslab/profil.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Asisten Laboratorium</title>
    
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
                        <a class="nav-link" href="/test-pengadaan">Pengadaan Barang</a>
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
                        <a class="nav-link active" href="/test-profil">Profil</a>
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
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Edit Profil</h1>
                </div>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="/test-profil">
                        @csrf
                        @method('PUT')
                        
                        <!-- Profile Information Section -->
                        <div class="form-section">
                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $user->nama_lengkap ?? 'John Doe') }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Kode Asisten Laboratorium -->
                            <div class="form-group">
                                <label for="kode_aslab" class="form-label required">Kode Asisten Laboratorium</label>
                                <input type="text" 
                                       class="form-control @error('kode_aslab') is-invalid @enderror" 
                                       id="kode_aslab" 
                                       name="kode_aslab" 
                                       value="{{ old('kode_aslab', $user->kode_aslab ?? 'ASLAB001') }}"
                                       placeholder="Masukkan kode asisten laboratorium"
                                       required>
                                @error('kode_aslab')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Kata Sandi -->
                            <div class="form-group">
                                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                                <input type="password" 
                                       class="form-control @error('kata_sandi') is-invalid @enderror" 
                                       id="kata_sandi" 
                                       name="kata_sandi" 
                                       placeholder="Kosongkan jika tidak ingin mengubah kata sandi">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah kata sandi</small>
                                @error('kata_sandi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Verifikasi Kata Sandi -->
                            <div class="form-group">
                                <label for="kata_sandi_confirmation" class="form-label">Verifikasi Kata Sandi</label>
                                <input type="password" 
                                       class="form-control @error('kata_sandi_confirmation') is-invalid @enderror" 
                                       id="kata_sandi_confirmation" 
                                       name="kata_sandi_confirmation" 
                                       placeholder="Ulangi kata sandi baru">
                                @error('kata_sandi_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="/test-dashboard" class="btn btn-secondary">Kembali</a>
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
                    // Check password confirmation
                    const password = document.getElementById('kata_sandi');
                    const confirmation = document.getElementById('kata_sandi_confirmation');
                    
                    if (password.value && password.value !== confirmation.value) {
                        event.preventDefault();
                        event.stopPropagation();
                        confirmation.setCustomValidity('Kata sandi tidak cocok');
                    } else {
                        confirmation.setCustomValidity('');
                    }
                    
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>