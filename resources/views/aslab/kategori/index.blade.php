{{-- resources/views/aslab/kategori/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang - Asisten Laboratorium</title>
    
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
                        <a class="nav-link" href="{{ route('aslab.pengadaan.index') }}">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peminjaman.index') }}">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aslab.keluhan.index') }}">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('aslab.barang.index') }}">Katalog Barang</a>
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
                                <a href="/home" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active">Katalog Barang</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Katalog Barang</h1>
                </div>
                
                <!-- Table Section -->
                <div class="table-section-full">
                    <div class="table-header-actions">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <h3 style="margin: 0;">Katalog Barang</h3>
                            <!-- Category Filter -->
                            <div class="form-group" style="margin: 0; min-width: 200px;">
                                <select class="form-control" id="categoryFilter" style="height: 40px; font-size: 14px;">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0" id="kategoriTable">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">ID KATEGORI</th>
                                        <th style="width: 35%;">NAMA KATEGORI</th>
                                        <th style="width: 30%;">JENIS BARANG</th>
                                        <th style="width: 20%;" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kategoris ?? [] as $kategori)
                                    <tr data-category="{{ $kategori->deskripsi }}">
                                        <td><span class="req-id">#{{ str_pad($kategori->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td><div class="item-name">{{ $kategori->nama_barang }}</div></td>
                                        <td><span class="date-text">{{ $kategori->deskripsi }}</span></td>
                                        <td class="text-end">
                                            <a href="{{ route('aslab.kategori.show', $kategori->id) }}" class="action-btn" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                            <p class="mt-2 text-muted">Belum ada kategori barang</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
    
    <!-- Delete Form (hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    
    <script>
        // Category Filter (mirror admin behavior)
        document.getElementById('categoryFilter')?.addEventListener('change', function() {
            const selectedCategory = this.value;
            const rows = document.querySelectorAll('#kategoriTable tbody tr');
            rows.forEach(row => {
                if (selectedCategory === '' || row.dataset.category === selectedCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Delete Confirmation
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                const form = document.getElementById('deleteForm');
                const baseUrl = '{{ route("aslab.kategori.destroy", ":id") }}';
                form.action = baseUrl.replace(':id', id);
                form.submit();
            }
        }
    </script>
</body>
</html>