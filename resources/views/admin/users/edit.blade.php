{{-- resources/views/admin/users/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Pengguna - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Bootstrap JS CDN as fallback -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="nav-container">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.users.index') }}">Kelola Profil Pengguna</a>
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
                        <a class="nav-link" href="{{ route('admin.users.edit', auth()->id()) }}">Profil</a>
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
                                <a href="admin/dashboard" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="admin/users" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Kelola Profil Pengguna</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Edit Pengguna</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-section">
                            <h3 class="section-title">Informasi Pribadi</h3>
                            
                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label for="nama_lengkap" class="form-label required">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
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
                                       value="{{ old('kode_aslab', $user->kode_aslab) }}"
                                       placeholder="Masukkan kode asisten laboratorium"
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
                                           value="{{ old('email', $user->email ?? '') }}"
                                           placeholder="Masukkan email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Username -->
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" 
                                           class="form-control @error('username') is-invalid @enderror" 
                                           id="username" 
                                           name="username" 
                                           value="{{ old('username', $user->username ?? '') }}"
                                           placeholder="Masukkan username">
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
                                    @php
                                        $userLabIds = $user->labs->pluck('id')->toArray();
                                        if (empty($userLabIds) && $user->id_lab) {
                                            $userLabIds = [$user->id_lab];
                                        }
                                        $isAslabEditingSelf = auth()->user()->role === 'aslab' && auth()->id() == $user->id;
                                        $labCount = count($userLabIds);
                                    @endphp
                                    
                                    @if($isAslabEditingSelf)
                                        {{-- Aslab editing own profile: Show read-only display --}}
                                        @if($labCount === 1)
                                            {{-- Single lab: Show as simple field --}}
                                            <input type="text" 
                                                   class="form-control" 
                                                   value="{{ $labs->firstWhere('id', $userLabIds[0])->nama_lab ?? 'N/A' }}"
                                                   readonly>
                                        @elseif($labCount > 1)
                                            {{-- Multiple labs: Show as badges --}}
                                            <div class="lab-badges-container" style="display: flex; flex-wrap: wrap; gap: 8px; padding: 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; min-height: 48px;">
                                                @foreach($userLabIds as $labId)
                                                    @php $lab = $labs->firstWhere('id', $labId); @endphp
                                                    @if($lab)
                                                        <span class="badge bg-success" style="font-size: 14px; padding: 8px 12px; font-weight: 500;">
                                                            <i class="bi bi-building"></i> {{ $lab->nama_lab }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <input type="text" class="form-control" value="Tidak ada lab terdaftar" readonly>
                                        @endif
                                        <small class="form-text text-muted">Hanya admin yang dapat mengubah informasi akademik</small>
                                        {{-- Hidden inputs to preserve lab data --}}
                                        @foreach($userLabIds as $labId)
                                            <input type="hidden" name="id_lab[]" value="{{ $labId }}">
                                        @endforeach
                                    @else
                                        {{-- Admin or editing other user: Show editable multi-select --}}
                                        <div style="display: flex; gap: 8px; align-items: start;">
                                            <div style="flex: 1;">
                                                <select class="form-control @error('id_lab') is-invalid @enderror" 
                                                        id="id_lab" 
                                                        name="id_lab[]"
                                                        multiple
                                                        size="5"
                                                        required>
                                                    @foreach($labs ?? [] as $lab)
                                                        <option value="{{ $lab->id }}" {{ (is_array(old('id_lab')) ? in_array($lab->id, old('id_lab')) : in_array($lab->id, $userLabIds)) ? 'selected' : '' }}>
                                                            {{ $lab->nama_lab }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">Tekan Ctrl (Windows) atau Cmd (Mac) untuk memilih beberapa lab</small>
                                                @error('id_lab')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="button" class="btn btn-outline-success" id="addLabBtn" style="white-space: nowrap;">
                                                <i class="bi bi-plus-circle"></i> Tambah Lab
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Jurusan -->
                                <div class="form-group">
                                    <label for="jurusan" class="form-label required">Jurusan</label>
                                    <input type="text" 
                                           class="form-control @error('jurusan') is-invalid @enderror" 
                                           id="jurusan" 
                                           name="jurusan" 
                                           value="{{ old('jurusan', $user->jurusan ?? '') }}"
                                           placeholder="Masukkan jurusan"
                                           {{ (auth()->user()->role === 'aslab' && auth()->id() == $user->id) ? 'readonly' : 'required' }}>
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
                                        {{ (auth()->user()->role === 'aslab' && auth()->id() == $user->id) ? 'disabled' : 'required' }}>
                                    <option value="">Pilih Role</option>
                                    <option value="aslab" {{ old('role', $user->role ?? 'aslab') == 'aslab' ? 'selected' : '' }}>Asisten Laboratorium</option>
                                    <option value="admin" {{ old('role', $user->role ?? 'aslab') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                                @if(auth()->user()->role === 'aslab' && auth()->id() == $user->id)
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                @endif
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="section-title">Ubah Password (Opsional)</h3>
                            <small class="form-text text-muted mb-3 d-block">Kosongkan jika tidak ingin mengubah password</small>
                            
                            <!-- Form Row: Password & Confirm Password -->
                            <div class="form-row">
                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan password baru">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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

    <!-- Add Lab Modal -->
    <div class="modal fade" id="addLabModal" tabindex="-1" aria-labelledby="addLabModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabModalLabel">Tambah Laboratorium Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addLabForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_lab" class="form-label">Nama Laboratorium</label>
                            <input type="text" class="form-control" id="nama_lab" name="nama_lab" placeholder="Contoh: Lab Kimia" required>
                            <div class="invalid-feedback" id="nama_lab_error"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveLabBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Wait for everything to load
        window.addEventListener('load', function() {
            console.log('Page loaded, setting up event listeners...');
            console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
            
            // Add Lab Modal Handler
            const addLabBtn = document.getElementById('addLabBtn');
            console.log('addLabBtn found:', addLabBtn);
            
            if (addLabBtn) {
                addLabBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Tambah Lab button clicked');
                    
                    const modalElement = document.getElementById('addLabModal');
                    console.log('Modal element found:', modalElement);
                    
                    if (modalElement && typeof bootstrap !== 'undefined') {
                        try {
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();
                            console.log('Modal shown successfully');
                        } catch (error) {
                            console.error('Error showing modal:', error);
                            alert('Error: ' + error.message);
                        }
                    } else {
                        console.error('Modal element or Bootstrap not found');
                        alert('Bootstrap tidak dimuat dengan benar. Silakan refresh halaman.');
                    }
                });
            } else {
                console.error('addLabBtn not found in DOM');
            }

            // Save Lab via AJAX
            const saveLabBtn = document.getElementById('saveLabBtn');
            if (saveLabBtn) {
                saveLabBtn.addEventListener('click', function() {
                    console.log('Save Lab button clicked');
                    const form = document.getElementById('addLabForm');
                    const formData = new FormData(form);
                    
                    fetch('{{ route("admin.labs.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`Server error: ${response.status} - ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Server response:', data);
                        if (data.success) {
                            // Add new lab to select dropdown
                            const select = document.getElementById('id_lab');
                            const option = new Option(data.lab.nama_lab, data.lab.id, true, true);
                            select.add(option);
                            
                            // Close modal and reset form
                            const modalElement = document.getElementById('addLabModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if (modal) {
                                modal.hide();
                            }
                            form.reset();
                            
                            // Show success message
                            alert(data.message);
                        } else {
                            alert('Gagal menambahkan lab: ' + (data.message || 'Kesalahan tidak diketahui'));
                        }
                    })
                    .catch(error => {
                        console.error('Full error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    });
                });
            }
        });

        // Form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('form')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    // Check password confirmation
                    const password = document.getElementById('password');
                    const confirmation = document.getElementById('password_confirmation');
                    
                    if (password.value && password.value !== confirmation.value) {
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