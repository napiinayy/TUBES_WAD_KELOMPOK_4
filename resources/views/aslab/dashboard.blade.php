{{-- resources/views/aslab/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Asisten Laboratorium</title>
    
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
                        <a class="nav-link active" href="/home">Beranda</a>
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
                        <a class="nav-link" href="{{ route('aslab.barang.index') }}">Katalog Barang</a>
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
                    <h1>Selamat Datang, {{ auth()->user()->nama_lengkap }}</h1>
                </div>
                
                <!-- Latest Entries Tables -->
                <div class="row g-4">
                    
                    <!-- Peminjaman Barang Table -->
                    <div class="col-12">
                        <div class="table-section">
                            <div class="table-header-admin">
                                <h3>Peminjaman Barang Terbaru</h3>
                                <a href="{{ route('peminjaman.index') }}" class="view-all-link">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="table-container-admin">
                                <div class="table-responsive">
                                    <table class="table dashboard-table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">ID Peminjaman</th>
                                                <th style="width: 20%;">Nama Barang</th>
                                                <th style="width: 15%;">Peminjam</th>
                                                <th style="width: 10%;">Kelas</th>
                                                <th style="width: 12%;">Tanggal Pinjam</th>
                                                <th style="width: 12%;">Tanggal Kembali</th>
                                                <th style="width: 8%;">Jumlah</th>
                                                <th style="width: 13%;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($peminjaman ?? [] as $item)
                                                <tr>
                                                    <td><span class="req-id">#BRW-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                                    <td><div class="item-name">{{ $item->nama_barang }}</div></td>
                                                    <td>
                                                        <div class="borrower-name">{{ $item->user->nama_lengkap ?? 'N/A' }}</div>
                                                        <div class="borrower-dept">{{ $item->lab->nama_lab ?? 'N/A' }}</div>
                                                    </td>
                                                    <td><span class="date-text">{{ $item->kelas }}</span></td>
                                                    <td><span class="date-text">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('M d, Y') }}</span></td>
                                                    <td><span class="date-text">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('M d, Y') }}</span></td>
                                                    <td><span class="quantity-badge">{{ $item->jumlah }}</span></td>
                                                    <td>
                                                        <span class="badge badge-{{ strtolower($item->status ?? 'dipinjam') }}">
                                                            {{ ucfirst($item->status ?? 'Dipinjam') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">Belum ada data peminjaman</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pengadaan Barang Table -->
                    <div class="col-12">
                        <div class="table-section">
                            <div class="table-header-admin">
                                <h3>Pengajuan Pengadaan Barang Terbaru</h3>
                                <a href="{{ route('aslab.pengadaan.index') }}" class="view-all-link">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="table-container-admin">
                                <div class="table-responsive">
                                    <table class="table dashboard-table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 12%;">ID Permintaan</th>
                                                <th style="width: 25%;">Detail Barang</th>
                                                <th style="width: 18%;">Pengaju</th>
                                                <th style="width: 15%;">Tanggal</th>
                                                <th style="width: 10%;">Jumlah</th>
                                                <th style="width: 20%;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengadaan ?? [] as $item)
                                                <tr>
                                                    <td><span class="req-id">#REQ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                                    <td><div class="item-name">{{ $item->nama_barang }}</div></td>
                                                    <td>
                                                        <div class="submitter-name">{{ $item->pengaju ?? 'N/A' }}</div>
                                                        <div class="submitter-dept">{{ $item->lab->nama_lab ?? 'N/A' }}</div>
                                                    </td>
                                                    <td><span class="date-text">{{ $item->created_at->format('M d, Y') }}</span></td>
                                                    <td><span class="quantity-badge">{{ $item->jumlah }}</span></td>
                                                    <td>
                                                        <span class="badge 
                                                            @if($item->status == 'pending') badge-pending
                                                            @elseif($item->status == 'approved') badge-approved
                                                            @elseif($item->status == 'rejected') badge-rejected
                                                            @endif">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">Belum ada data pengadaan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Keluhan Table -->
                    <div class="col-12">
                        <div class="table-section">
                            <div class="table-header-admin">
                                <h3>Keluhan Terbaru</h3>
                                <a href="{{ route('aslab.keluhan.index') }}" class="view-all-link">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="table-container-admin">
                                <div class="table-responsive">
                                    <table class="table dashboard-table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;">Keluhan</th>
                                                <th style="width: 25%;">Pelapor</th>
                                                <th style="width: 20%;">Status</th>
                                                <th style="width: 15%;">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($keluhan ?? [] as $item)
                                                <tr>
                                                    <td><div class="item-name">{{ Str::limit($item->nama_item, 50) }}</div></td>
                                                    <td>
                                                        <div class="submitter-name">{{ $item->pelapor ?? 'N/A' }}</div>
                                                        <div class="submitter-dept">{{ $item->jenis_keluhan }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge 
                                                            @if($item->status == 'pending') badge-pending
                                                            @elseif($item->status == 'resolved') badge-resolved
                                                            @elseif($item->status == 'rejected') badge-rejected
                                                            @endif">
                                                            {{ ucfirst($item->status) }}
                                                        </span>
                                                    </td>
                                                    <td><span class="date-text">{{ $item->created_at->format('M d, Y') }}</span></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">Belum ada keluhan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/js/app.js')
</body>
</html>