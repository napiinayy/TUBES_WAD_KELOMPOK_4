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
                        <a class="nav-link" href="/home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/aslab/pengadaan">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/aslab/peminjaman">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.barang.index') }}">Katalog Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/users">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/test-profil">Profil</a>
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
                    <form method="POST" action="{{ route('admin.users.update', auth()->id()) }}">
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
                        
                        <!-- Academic Information Section (Read-only) -->
                        <div class="form-section">
                            <h3 class="section-title">Informasi Akademik</h3>
                            <p class="text-muted mb-3"><small><i class="bi bi-info-circle"></i> Informasi ini hanya dapat diubah oleh admin</small></p>
                            
                            <!-- Nama Laboratorium -->
                            <div class="form-group">
                                <label class="form-label">Nama Laboratorium</label>
                                @php
                                    $userLabs = $user->labs ?? collect();
                                    $labCount = $userLabs->count();
                                @endphp
                                
                                @if($labCount === 1)
                                    {{-- Single lab: Show as simple read-only field --}}
                                    <input type="text" 
                                           class="form-control" 
                                           value="{{ $userLabs->first()->nama_lab }}"
                                           readonly>
                                @elseif($labCount > 1)
                                    {{-- Multiple labs: Show as badges/tags --}}
                                    <div class="lab-badges-container" style="display: flex; flex-wrap: wrap; gap: 8px; padding: 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; min-height: 48px;">
                                        @foreach($userLabs as $lab)
                                            <span class="badge bg-success" style="font-size: 14px; padding: 8px 12px; font-weight: 500;">
                                                <i class="bi bi-building"></i> {{ $lab->nama_lab }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <input type="text" 
                                           class="form-control" 
                                           value="Tidak ada lab terdaftar"
                                           readonly>
                                @endif
                            </div>
                            
                            <!-- Jurusan -->
                            <div class="form-group">
                                <label class="form-label">Jurusan</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $user->jurusan ?? '-' }}"
                                       readonly>
                            </div>
                            
                            <!-- Role -->
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ ucfirst($user->role ?? 'aslab') }}"
                                       readonly>
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="{{ route('admin.users.edit', auth()->id()) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Batal
                            </a>
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