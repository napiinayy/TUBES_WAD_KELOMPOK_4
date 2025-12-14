{{-- resources/views/aslab/kategori/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Barang - Asisten Laboratorium</title>
    
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
                        <a class="nav-link" href="keluhan">Keluhan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="kategori">Kategori Barang</a>
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
                            <li class="breadcrumb-item active">Kategori Barang</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Header -->
                <div class="page-header">
                    <h1>Kategori Barang</h1>
                </div>
                
                <!-- Info Alert -->
                <div class="alert alert-info mb-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Anda hanya dapat melihat daftar kategori barang. Untuk menambah, mengubah, atau menghapus kategori, silakan hubungi Administrator.
                </div>
                
                <!-- Table Section -->
                <div class="table-section-full">
                    <div class="table-header-actions">
                        <h3>Daftar Kategori</h3>
                        <button class="btn btn-secondary" disabled>
                            <i class="bi bi-lock me-2"></i>
                            Admin Only
                        </button>
                    </div>
                    <div class="table-container standalone">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">ID Barang</th>
                                        <th style="width: 40%;">Nama Barang</th>
                                        <th style="width: 35%;">Jenis Barang</th>
                                        <th style="width: 10%;" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kategoris ?? [] as $kategori)
                                    <tr>
                                        <td><span class="req-id">#{{ str_pad($kategori->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td><div class="item-name">{{ $kategori->nama_barang }}</div></td>
                                        <td><span class="date-text">{{ $kategori->jenis_barang }}</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <!-- Sample Data for Demo -->
                                    <tr>
                                        <td><span class="req-id">#0001</span></td>
                                        <td><div class="item-name">Mikroskop Digital</div></td>
                                        <td><span class="date-text">Alat Laboratorium</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="req-id">#0002</span></td>
                                        <td><div class="item-name">Beaker Glass 500ml</div></td>
                                        <td><span class="date-text">Peralatan Gelas</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="req-id">#0003</span></td>
                                        <td><div class="item-name">pH Meter Digital</div></td>
                                        <td><span class="date-text">Alat Ukur</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="req-id">#0004</span></td>
                                        <td><div class="item-name">Bunsen Burner</div></td>
                                        <td><span class="date-text">Alat Pemanas</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="req-id">#0005</span></td>
                                        <td><div class="item-name">Centrifuge</div></td>
                                        <td><span class="date-text">Alat Laboratorium</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="req-id">#0006</span></td>
                                        <td><div class="item-name">Erlenmeyer Flask 250ml</div></td>
                                        <td><span class="date-text">Peralatan Gelas</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="req-id">#0007</span></td>
                                        <td><div class="item-name">Pipet Volumetrik 25ml</div></td>
                                        <td><span class="date-text">Peralatan Gelas</span></td>
                                        <td class="text-end">
                                            <button class="action-btn" disabled title="View (Admin Only)">
                                                <i class="bi bi-eye"></i>
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
</body>
</html>