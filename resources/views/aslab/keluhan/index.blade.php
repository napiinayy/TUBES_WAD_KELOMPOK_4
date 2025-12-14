{{-- resources/views/aslab/keluhan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluhan - Asisten Laboratorium</title>
    
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
                        <a class="nav-link" href="dashboard">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengadaan">Pengadaan Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="peminjaman">Peminjaman Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="keluhan">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kategori">Kategori Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil">Profil</a>
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
                                <a href="dashboard" class="text-decoration-none" style="color: rgba(0, 0, 0, 0.6);">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active">Keluhan</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Keluhan</h1>
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
                        <h3>Daftar Keluhan</h3>
                        <a href="keluhan/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Keluhan
                        </a>
                    </div>
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th style="width: 10%;">ID Keluhan</th>
                                        <th style="width: 25%;">Nama Item</th>
                                        <th style="width: 15%;">Jenis Keluhan</th>
                                        <th style="width: 15%;">Pelapor</th>
                                        <th style="width: 12%;">Tanggal</th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 8%;" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($keluhans ?? [] as $keluhan)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                        </td>
                                        <td><span class="req-id">#KLH-{{ str_pad($keluhan->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td><div class="item-name">{{ $keluhan->nama_item }}</div></td>
                                        <td><span class="date-text">{{ $keluhan->jenis_keluhan }}</span></td>
                                        <td>
                                            <div class="submitter-name">{{ $keluhan->pelapor }}</div>
                                        </td>
                                        <td><span class="date-text">{{ $keluhan->created_at->format('M d, Y') }}</span></td>
                                        <td>
                                            @if($keluhan->status == 'approved')
                                                <span class="badge badge-approved">Approved</span>
                                            @elseif($keluhan->status == 'rejected')
                                                <span class="badge badge-rejected">Rejected</span>
                                            @else
                                                <span class="badge badge-pending">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="keluhan/{{ $keluhan->id }}" class="action-btn" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button class="action-btn" title="Delete" onclick="confirmDelete({{ $keluhan->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                            <p class="mt-2 text-muted">Belum ada keluhan</p>
                                            <a href="keluhan/create" class="btn btn-primary btn-sm mt-2">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                Tambah Keluhan Pertama
                                            </a>
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
        // Select All Checkbox
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        // Delete Confirmation
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus keluhan ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = 'keluhan/' + id;
                form.submit();
            }
        }
    </script>
</body>
</html>