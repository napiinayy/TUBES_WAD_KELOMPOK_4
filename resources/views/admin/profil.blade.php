{{-- resources/views/admin/profil.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Admin</title>
    
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
                        <a class="nav-link" href="/home">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">Kelola Profil Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/kategori">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/keluhan">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/profil">Profil</a>
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
                    <form method="POST" action="/admin/profil">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informasi Akun Section -->
                        <div class="form-section">
                            <h3 class="section-title">Informasi Akun</h3>
                            
                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $user->nama_lengkap ?? 'Admin User') }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Username -->
                            <div class="form-group">
                                <label for="username" class="form-label required">Username</label>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username', $user->username ?? 'admin') }}"
                                       placeholder="Masukkan username"
                                       required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Ubah Kata Sandi Section -->
                        <div class="form-section">
                            <h3 class="section-title">Ubah Kata Sandi</h3>
                            <p class="text-muted mb-3" style="font-size: 0.875rem;">Kosongkan jika tidak ingin mengubah kata sandi</p>
                            
                            <!-- Kata Sandi Saat Ini -->
                            <div class="form-group">
                                <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       placeholder="Masukkan kata sandi saat ini">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Form Row: Kata Sandi Baru & Verifikasi -->
                            <div class="form-row">
                                <!-- Kata Sandi Baru -->
                                <div class="form-group">
                                    <label for="password" class="form-label">Kata Sandi Baru</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan kata sandi baru">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Verifikasi Kata Sandi -->
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Verifikasi Kata Sandi</label>
                                    <input type="password" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Ulangi kata sandi baru">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="/admin/dashboard" class="btn btn-secondary">Kembali</a>
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
        
        // Validate password confirmation
        document.getElementById('password_confirmation')?.addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password && confirmation && password !== confirmation) {
                this.setCustomValidity('Kata sandi tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>