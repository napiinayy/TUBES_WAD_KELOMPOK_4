{{-- resources/views/admin/users/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Profil Pengguna - Admin</title>
    
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
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Kelola Profil Pengguna</h1>
                </div>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Table Section -->
                <div class="table-section-full">
                    <div class="table-header-actions">
                        <h3>Daftar Pengguna</h3>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Pengguna
                        </a>
                    </div>
                    
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Kode Aslab</th>
                                        <th style="width: 25%;">Nama Lengkap</th>
                                        <th style="width: 20%;">Laboratorium</th>
                                        <th style="width: 15%;">Jurusan</th>
                                        <th style="width: 20%;" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users ?? [] as $user)
                                        <tr>
                                            <td><span class="req-id">{{ $user->kode_aslab }}</span></td>
                                            <td><div class="item-name">{{ $user->nama_lengkap }}</div></td>
                                            <td><span class="date-text">{{ $user->lab_name ?? '-' }}</span></td>
                                            <td><span class="date-text">{{ $user->jurusan }}</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete({{ $user->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- Sample Data -->
                                        <tr>
                                            <td><span class="req-id">ASLAB001</span></td>
                                            <td><div class="item-name">Ahmad Fauzi</div></td>
                                            <td><span class="date-text">Lab Kimia</span></td>
                                            <td><span class="date-text">Teknik Kimia</span></td>
                                            <td class="text-end">
                                                <a href="/admin/users/1" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/users/1/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(1)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="req-id">ASLAB002</span></td>
                                            <td><div class="item-name">Siti Nurhaliza</div></td>
                                            <td><span class="date-text">Lab Fisika</span></td>
                                            <td><span class="date-text">Teknik Fisika</span></td>
                                            <td class="text-end">
                                                <a href="/admin/users/2" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/users/2/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(2)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="req-id">ASLAB003</span></td>
                                            <td><div class="item-name">Budi Santoso</div></td>
                                            <td><span class="date-text">Lab Biologi</span></td>
                                            <td><span class="date-text">Biologi</span></td>
                                            <td class="text-end">
                                                <a href="/admin/users/3" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/users/3/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(3)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="req-id">ASLAB004</span></td>
                                            <td><div class="item-name">Rina Wati</div></td>
                                            <td><span class="date-text">Lab Komputer</span></td>
                                            <td><span class="date-text">Informatika</span></td>
                                            <td class="text-end">
                                                <a href="/admin/users/4" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/users/4/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(4)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="req-id">ASLAB005</span></td>
                                            <td><div class="item-name">Dedi Kurniawan</div></td>
                                            <td><span class="date-text">Lab Kimia</span></td>
                                            <td><span class="date-text">Kimia Murni</span></td>
                                            <td class="text-end">
                                                <a href="/admin/users/5" class="action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/users/5/edit" class="action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="action-btn" title="Delete" onclick="confirmDelete(5)">
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
        // Confirm delete
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = '/admin/users/' + id;
                form.submit();
            }
        }
    </script>
</body>
</html>