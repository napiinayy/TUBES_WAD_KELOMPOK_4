{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="admin-container">
        <!-- Main Content -->
        <main class="admin-main-content">
            <div class="admin-content-wrapper">
                <h1 class="admin-welcome-title">Selamat Datang</h1>
                
                <!-- Statistics Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Total Pengguna</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-tags-fill"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $totalBarangs }}</h3>
                            <p>Total Barang</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $totalKeluhans }}</h3>
                            <p>Total Keluhan</p>
                        </div>
                    </div>
                </div>
                
                <!-- Latest Entries Tables -->
                <div class="latest-entries-container">
                    <!-- Latest Users Table -->
                    <div class="table-section">
                        <div class="table-header-admin">
                            <h3>Pengguna Terbaru</h3>
                            <a href="{{ route('admin.users.index') }}" class="view-all-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="table-container-admin">
                            <div class="table-responsive">
                                <table class="table dashboard-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Nama Lengkap</th>
                                            <th style="width: 20%;">Username</th>
                                            <th style="width: 15%;">Role</th>
                                            <th style="width: 25%;">Laboratorium</th>
                                            <th style="width: 15%;">Tanggal Dibuat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestUsers as $user)
                                            <tr>
                                                <td><div class="item-name">{{ $user->nama_lengkap }}</div></td>
                                                <td><span class="req-id">{{ $user->username }}</span></td>
                                                <td><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></td>
                                                <td><span class="date-text">{{ $user->lab_name }}</span></td>
                                                <td><span class="date-text">{{ $user->created_at->format('M d, Y') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada pengguna</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Barang Table -->
                    <div class="table-section">
                        <div class="table-header-admin">
                            <h3>Barang Terbaru</h3>
                            <a href="{{ route('admin.barang.index') }}" class="view-all-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="table-container-admin">
                            <div class="table-responsive">
                                <table class="table dashboard-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Nama Barang</th>
                                            <th style="width: 30%;">Kategori</th>
                                            <th style="width: 20%;">Deskripsi</th>
                                            <th style="width: 20%;">Tanggal Dibuat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestBarangs as $barang)
                                            <tr>
                                                <td><div class="item-name">{{ $barang->nama_barang }}</div></td>
                                                <td><span class="date-text">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                                <td><span class="date-text">{{ $barang->deskripsi ?? '-' }}</span></td>
                                                <td><span class="date-text">{{ $barang->created_at->format('M d, Y') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada barang</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Complaints Table -->
                    <div class="table-section">
                        <div class="table-header-admin">
                            <h3>Keluhan Terbaru</h3>
                            <a href="{{ route('admin.keluhan.index') }}" class="view-all-link">
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
                                        @forelse($latestKeluhans as $keluhan)
                                            <tr>
                                                <td><div class="item-name">{{ Str::limit($keluhan->nama_item, 50) }}</div></td>
                                                <td>
                                                    <div class="submitter-name">{{ $keluhan->pelapor ?? 'N/A' }}</div>
                                                    <div class="submitter-dept">{{ $keluhan->jenis_keluhan }}</div>
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @if($keluhan->status == 'pending') bg-warning
                                                        @elseif($keluhan->status == 'resolved') bg-success
                                                        @elseif($keluhan->status == 'rejected') bg-danger
                                                        @endif">
                                                        {{ ucfirst($keluhan->status) }}
                                                    </span>
                                                </td>
                                                <td><span class="date-text">{{ $keluhan->created_at->format('M d, Y') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada keluhan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pengajuan Barang Table -->
                <div class="table-section">
                    <div class="table-header-admin">
                        <h3>Pengajuan Barang</h3>
                    </div>
                    <div class="table-container-admin">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 12%;">ID Permintaan</th>
                                        <th style="width: 20%;">Detail Barang</th>
                                        <th style="width: 15%;">Pengaju</th>
                                        <th style="width: 13%;">Tanggal</th>
                                        <th style="width: 10%;">Jumlah</th>
                                        <th style="width: 12%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengadaan ?? [] as $item)
                                        <tr>
                                            <td><span class="req-id">{{ $item->id }}</span></td>
                                            <td><div class="item-name">{{ $item->nama_barang }}</div></td>
                                            <td>
                                                <div class="submitter-name">{{ $item->pengaju ?? 'N/A' }}</div>
                                                <div class="submitter-dept">{{ $item->lab->nama_lab ?? 'N/A' }}</div>
                                            </td>
                                            <td><span class="date-text">{{ $item->created_at->format('M d, Y') }}</span></td>
                                            <td><span class="quantity-badge">{{ $item->jumlah }}</span></td>
                                            <td>
                                                <select class="form-select form-select-sm status-select" 
                                                        data-id="{{ $item->id }}" 
                                                        data-type="pengadaan">
                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td><span class="req-id">#REQ-2048</span></td>
                                            <td><div class="item-name">Digital Centrifuge</div></td>
                                            <td>
                                                <div class="submitter-name">John Smith</div>
                                                <div class="submitter-dept">Chemistry</div>
                                            </td>
                                            <td><span class="date-text">Oct 23, 2023</span></td>
                                            <td><span class="quantity-badge">1</span></td>
                                            <td>
                                                <select class="form-select form-select-sm status-select">
                                                    <option value="pending">Pending</option>
                                                    <option value="approved" selected>Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="req-id">#REQ-2047</span></td>
                                            <td><div class="item-name">Beaker Set (500ml)</div></td>
                                            <td>
                                                <div class="submitter-name">Alice Wong</div>
                                                <div class="submitter-dept">Physics</div>
                                            </td>
                                            <td><span class="date-text">Oct 22, 2023</span></td>
                                            <td><span class="quantity-badge">2</span></td>
                                            <td>
                                                <select class="form-select form-select-sm status-select">
                                                    <option value="pending" selected>Pending</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Peminjaman Barang Table -->
                <div class="table-section">
                    <div class="table-header-admin">
                        <h3>Peminjaman Barang</h3>
                    </div>
                    <div class="table-container-admin">
                        <div class="table-responsive">
                            <table class="table dashboard-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID Peminjaman</th>
                                        <th style="width: 18%;">Nama Barang</th>
                                        <th style="width: 12%;">Peminjam</th>
                                        <th style="width: 8%;">Kelas</th>
                                        <th style="width: 11%;">Tanggal Pinjam</th>
                                        <th style="width: 11%;">Tanggal Kembali</th>
                                        <th style="width: 8%;">Jumlah</th>
                                        <th style="width: 10%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($peminjaman ?? [] as $item)
                                        <tr>
                                            <td><span class="req-id">{{ $item->id }}</span></td>
                                            <td><div class="item-name">{{ $item->nama_barang }}</div></td>
                                            <td>
                                                <div class="borrower-name">{{ $item->user->nama_lengkap ?? 'N/A' }}</div>
                                                <div class="borrower-dept">{{ $item->lab->nama_lab ?? 'N/A' }}</div>
                                            </td>
                                            <td><span class="date-text">{{ $item->kelas }}</span></td>
                                            <td><span class="date-text">{{ $item->tanggal_pinjam }}</span></td>
                                            <td><span class="date-text">{{ $item->tanggal_kembali }}</span></td>
                                            <td><span class="quantity-badge">{{ $item->jumlah }}</span></td>
                                            <td>
                                                <select class="form-select form-select-sm status-select" 
                                                        data-id="{{ $item->id }}" 
                                                        data-type="peminjaman">
                                                    <option value="dipinjam" {{ $item->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                                    <option value="dikembalikan" {{ $item->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                                    <option value="terlambat" {{ $item->status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td><span class="req-id">#BRW-1025</span></td>
                                            <td><div class="item-name">Microscope Olympus CX23</div></td>
                                            <td>
                                                <div class="borrower-name">Emma Wilson</div>
                                                <div class="borrower-dept">Biology</div>
                                            </td>
                                            <td><span class="date-text">XII-A</span></td>
                                            <td><span class="date-text">Oct 20, 2023</span></td>
                                            <td><span class="date-text">Oct 27, 2023</span></td>
                                            <td><span class="quantity-badge">1</span></td>
                                            <td>
                                                <select class="form-select form-select-sm status-select">
                                                    <option value="dipinjam" selected>Dipinjam</option>
                                                    <option value="dikembalikan">Dikembalikan</option>
                                                    <option value="terlambat">Terlambat</option>
                                                </select>
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
        
        <!-- Sidebar (Right side) -->
        <aside class="admin-sidebar">
            <div class="admin-nav-container">
                <ul class="admin-nav">
                    <li class="admin-nav-item">
                        <a class="admin-nav-link active" href="/home">Dashboard</a>
                    </li>
                    <li class="admin-nav-item">
                        <a class="admin-nav-link" href="/admin/users">Kelola Profil Pengguna</a>
                    </li>
                    <li class="admin-nav-item">
                        <a class="admin-nav-link" href="/admin/barang">Daftar Barang</a>
                    </li>
                    <li class="admin-nav-item">
                        <a class="admin-nav-link" href="{{ route('admin.kategoris.index') }}">Kelola Kategori</a>
                    </li>
                    <li class="admin-nav-item">
                        <a class="admin-nav-link" href="/admin/keluhan">Keluhan</a>
                    </li>
                    <li class="admin-nav-item">
                        <a class="admin-nav-link" href="{{ route('admin.users.edit', auth()->id()) }}">Profil</a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer" style="margin-top: auto; padding-top: 16px;">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="admin-nav-link logout-btn" style="width: 100%; text-align: left; background: transparent; border: none; cursor: pointer; padding: 10px 12px; display: flex; align-items: center; gap: 12px;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </aside>
    </div>
    
    <script>
        // Select all checkboxes
        document.getElementById('selectAllPengajuan')?.addEventListener('change', function() {
            const table = this.closest('table');
            const checkboxes = table.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        document.getElementById('selectAllPeminjaman')?.addEventListener('change', function() {
            const table = this.closest('table');
            const checkboxes = table.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        document.getElementById('selectAllKeluhan')?.addEventListener('change', function() {
            const table = this.closest('table');
            const checkboxes = table.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
        
        // Update status
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const id = this.dataset.id;
                const type = this.dataset.type;
                const status = this.value;
                
                fetch(`/admin/${type}/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        console.log('Status updated successfully');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
        
        function viewDetail(type, id) {
            window.location.href = `/admin/${type}/${id}`;
        }
    </script>
</body>
</html>