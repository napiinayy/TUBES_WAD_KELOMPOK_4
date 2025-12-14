{{-- resources/views/admin/kategori/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kategori Barang - Admin</title>
    
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
                        <a class="nav-link active" href="/admin/kategori">Kategori Barang</a>
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
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Kategori Barang</h1>
                </div>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Filter & Actions Section -->
                <div class="table-section-full">
                    <div class="table-header-actions">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <h3 style="margin: 0;">Daftar Kategori</h3>
                            
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
                        
                        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Kategori
                        </a>
                    </div>
                    
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0" id="kategoriTable">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">ID Kategori</th>
                                        <th style="width: 35%;">Nama Kategori</th>
                                        <th style="width: 30%;">Deskripsi</th>
                                        <th style="width: 20%;" class="text-end">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kategoris ?? [] as $kategori)
                                        <tr>
                                            <td><span class="req-id">#{{ str_pad($kategori->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                            <td><div class="item-name">{{ $kategori->nama_kategori }}</div></td>
                                            <td><span class="date-text">{{ $kategori->deskripsi }}</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.kategori.show', $kategori->id) }}" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete({{ $kategori->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="text-muted mb-0">Belum ada data kategori</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                                            <td><span class="date-text">{{ $item->jenis_barang }}</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/{{ $item->id }}" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/{{ $item->id }}/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete({{ $item->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- Sample Data -->
                                        <tr data-category="Alat Laboratorium">
                                            <td><span class="req-id">#0001</span></td>
                                            <td><div class="item-name">Microscope Olympus CX23</div></td>
                                            <td><span class="date-text">Alat Laboratorium</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/1" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/1/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(1)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Laboratorium">
                                            <td><span class="req-id">#0002</span></td>
                                            <td><div class="item-name">Digital Centrifuge</div></td>
                                            <td><span class="date-text">Alat Laboratorium</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/2" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/2/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(2)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Gelas">
                                            <td><span class="req-id">#0003</span></td>
                                            <td><div class="item-name">Beaker Set (500ml)</div></td>
                                            <td><span class="date-text">Alat Gelas</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/3" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/3/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(3)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Ukur">
                                            <td><span class="req-id">#0004</span></td>
                                            <td><div class="item-name">pH Meter Digital</div></td>
                                            <td><span class="date-text">Alat Ukur</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/4" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/4/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(4)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Pemanas">
                                            <td><span class="req-id">#0005</span></td>
                                            <td><div class="item-name">Bunsen Burner</div></td>
                                            <td><span class="date-text">Alat Pemanas</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/5" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/5/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(5)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="APD">
                                            <td><span class="req-id">#0006</span></td>
                                            <td><div class="item-name">Safety Goggles</div></td>
                                            <td><span class="date-text">APD</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/6" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/6/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(6)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="APD">
                                            <td><span class="req-id">#0007</span></td>
                                            <td><div class="item-name">Lab Coat</div></td>
                                            <td><span class="date-text">APD</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/7" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/7/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(7)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Ukur">
                                            <td><span class="req-id">#0008</span></td>
                                            <td><div class="item-name">Analytical Balance</div></td>
                                            <td><span class="date-text">Alat Ukur</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/8" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/8/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(8)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Gelas">
                                            <td><span class="req-id">#0009</span></td>
                                            <td><div class="item-name">Pipette Set</div></td>
                                            <td><span class="date-text">Alat Gelas</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/9" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/9/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(9)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-category="Alat Ukur">
                                            <td><span class="req-id">#0010</span></td>
                                            <td><div class="item-name">Thermometer Digital</div></td>
                                            <td><span class="date-text">Alat Ukur</span></td>
                                            <td class="text-end">
                                                <a href="/admin/kategori/10" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/kategori/10/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(10)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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
        // Category Filter
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
        
        // Confirm delete
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = '{{ route('admin.kategori.destroy', '') }}' + id;
                form.submit();
            }
        }
    </script>
</body>
</html>