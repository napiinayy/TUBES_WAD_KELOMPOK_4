{{-- resources/views/admin/kategori/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori Barang - Admin</title>
    
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
                        <a class="nav-link" href="admin/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/users">Kelola Profil Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin/kategori">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/profil">Profil</a>
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
                                <a href="admin/dashboard" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="admin/kategori" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Kategori Barang</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Edit Kategori Barang</h1>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form method="POST" action="admin/kategori/{{ $item->id }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-section">
                            <h3 class="section-title">Informasi Barang</h3>
                            
                            <!-- ID Barang (Read-only) -->
                            <div class="form-group">
                                <label for="id" class="form-label">ID Barang</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="id" 
                                       value="#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}"
                                       disabled>
                            </div>
                            
                            <!-- Nama Barang -->
                            <div class="form-group">
                                <label for="nama_barang" class="form-label required">Nama Barang</label>
                                <input type="text" 
                                       class="form-control @error('nama_barang') is-invalid @enderror" 
                                       id="nama_barang" 
                                       name="nama_barang" 
                                       value="{{ old('nama_barang', $item->nama_barang) }}"
                                       placeholder="Masukkan nama barang"
                                       required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Jenis Barang with Dropdown and Custom Option -->
                            <div class="form-group">
                                <label for="jenis_barang" class="form-label required">Jenis Barang</label>
                                <select class="form-control @error('jenis_barang') is-invalid @enderror" 
                                        id="jenis_barang_select" 
                                        name="jenis_barang_select"
                                        required>
                                    <option value="">Pilih Jenis Barang</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category }}" {{ old('jenis_barang', $item->jenis_barang) == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                    <option value="custom">+ Tambah Kategori Baru</option>
                                </select>
                                @error('jenis_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Custom Category Input (Hidden by default) -->
                            <div class="form-group" id="customCategoryGroup" style="display: none;">
                                <label for="jenis_barang_custom" class="form-label required">Nama Kategori Baru</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="jenis_barang_custom" 
                                       name="jenis_barang_custom" 
                                       placeholder="Masukkan nama kategori baru">
                                <small class="form-text text-muted">Kategori ini akan ditambahkan ke daftar pilihan</small>
                            </div>
                            
                            <!-- Hidden input for final jenis_barang value -->
                            <input type="hidden" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang', $item->jenis_barang) }}">
                        </div>
                        
                        <!-- Form Footer -->
                        <div class="form-footer">
                            <a href="/admin/kategori" class="btn btn-secondary">Batal</a>
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
        const selectElement = document.getElementById('jenis_barang_select');
        const customGroup = document.getElementById('customCategoryGroup');
        const customInput = document.getElementById('jenis_barang_custom');
        const hiddenInput = document.getElementById('jenis_barang');
        const form = document.querySelector('form');
        
        // Show/hide custom category input
        selectElement.addEventListener('change', function() {
            if (this.value === 'custom') {
                customGroup.style.display = 'block';
                customInput.required = true;
                hiddenInput.value = '';
            } else {
                customGroup.style.display = 'none';
                customInput.required = false;
                customInput.value = '';
                hiddenInput.value = this.value;
            }
        });
        
        // Update hidden input when custom input changes
        customInput.addEventListener('input', function() {
            hiddenInput.value = this.value;
        });
        
        // Form validation
        form.addEventListener('submit', function(e) {
            const selectValue = selectElement.value;
            
            if (selectValue === 'custom') {
                if (!customInput.value.trim()) {
                    e.preventDefault();
                    alert('Silakan masukkan nama kategori baru');
                    return false;
                }
                hiddenInput.value = customInput.value.trim();
            } else if (!selectValue) {
                e.preventDefault();
                alert('Silakan pilih jenis barang');
                return false;
            } else {
                hiddenInput.value = selectValue;
            }
        });
    </script>
</body>
</html>