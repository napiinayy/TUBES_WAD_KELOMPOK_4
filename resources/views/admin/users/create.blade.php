{{-- resources/views/admin/users/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Admin</title>
    
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
                        <a class="nav-link active" href="/admin/users">Kelola Profil Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/kategori">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.keluhan.index') }}">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.edit', auth()->id()) }}">Profil</a>
                    </li>
                </ul>
            </div>
            
            <div class="sidebar-footer">
                <div class="logout-section">
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
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
                                <a href="/home" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/admin/users" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Kelola Profil Pengguna</a>
                            </li>
                            <li class="breadcrumb-item active">Tambah Pengguna</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Tambah Pengguna</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
                        <div class="form-section">
                            <h3 class="section-title">Informasi Pribadi</h3>
                            
                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap') }}"
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
                                       value="{{ old('kode_aslab') }}"
                                       placeholder="Contoh: ASLAB001"
                                       required>
                                @error('kode_aslab')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Form Row: Email & Username -->
                            <div class="form-row">
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="Masukkan email">
                                    @error('email')
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
                                           value="{{ old('username') }}"
                                           placeholder="Masukkan username"
                                           required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="section-title">Informasi Akademik</h3>
                            
                            <!-- Form Row: Lab & Jurusan -->
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
                                
                                <!-- Jurusan -->
                                <div class="form-group">
                                    <label for="jurusan" class="form-label required">Jurusan</label>
                                    <input type="text" 
                                           class="form-control @error('jurusan') is-invalid @enderror" 
                                           id="jurusan" 
                                           name="jurusan" 
                                           value="{{ old('jurusan') }}"
                                           placeholder="Masukkan jurusan"
                                           required>
                                    @error('jurusan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Role -->
                            <div class="form-group">
                                <label for="role" class="form-label required">Role</label>
                                <select class="form-control @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role"
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="aslab" {{ old('role') == 'aslab' ? 'selected' : '' }}>Asisten Laboratorium</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="section-title">Password</h3>
                            
                            <!-- Form Row: Password & Confirm Password -->
                            <div class="form-row">
                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password" class="form-label required">Password</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan password"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Ulangi password"
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="/admin/users" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Simpan
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
                    const password = document.getElementById('password');
                    const confirmation = document.getElementById('password_confirmation');
                    
                    if (password.value !== confirmation.value) {
                        event.preventDefault();
                        event.stopPropagation();
                        alert('Password dan konfirmasi password tidak cocok');
                        return false;
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