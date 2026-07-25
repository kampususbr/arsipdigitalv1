@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-title">Dashboard</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stat-card">
            <div class="stat-card-icon"><i class="fas fa-file-pdf"></i></div>
            <div class="stat-card-value">{{ $totalDocuments }}</div>
            <div class="stat-card-label">Total Dokumen</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stat-card">
            <div class="stat-card-icon"><i class="fas fa-users"></i></div>
            <div class="stat-card-value">{{ $totalUsers }}</div>
            <div class="stat-card-label">Total Pengguna</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stat-card">
            <div class="stat-card-icon"><i class="fas fa-tags"></i></div>
            <div class="stat-card-value">{{ $totalCategories }}</div>
            <div class="stat-card-label">Total Kategori</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card stat-card">
            <div class="stat-card-icon"><i class="fas fa-database"></i></div>
            <div class="stat-card-value">{{ $storageUsedGB }}GB</div>
            <div class="stat-card-label">Storage Terpakai</div>
        </div>
    </div>
</div>

<!-- Activity Cards -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-upload"></i> Upload Hari Ini</h6>
            </div>
            <div class="card-body">
                <h3 class="text-primary mb-2">{{ $documentsToday }}</h3>
                <small class="text-muted">Dokumen berhasil diupload</small>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-calendar"></i> Upload Bulan Ini</h6>
            </div>
            <div class="card-body">
                <h3 class="text-success mb-2">{{ $documentsThisMonth }}</h3>
                <small class="text-muted">Dokumen di bulan {{ now()->locale('id')->monthName }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Documents by Category -->
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Dokumen per Kategori</h6>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Storage Usage -->
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-hdd"></i> Penggunaan Storage</h6>
            </div>
            <div class="card-body">
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $storageUsedPercent }}%" aria-valuenow="{{ $storageUsedPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ number_format($storageUsedPercent, 1) }}%
                    </div>
                </div>
                <small class="text-muted">{{ $storageUsedGB }}GB dari 10GB</small>
            </div>
        </div>
    </div>
</div>

<!-- Documents Upload Trend -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-line"></i> Tren Upload 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <canvas id="uploadTrendChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Content Sections -->
<div class="row mb-4">
    <!-- Top Categories -->
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-star"></i> Kategori Terpopuler</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($topCategories as $category)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $category->name }}</h6>
                            <small class="text-muted">{{ $category->documents_count }} dokumen</small>
                        </div>
                        <span class="badge bg-primary">{{ $category->documents_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Most Viewed Documents -->
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-eye"></i> Dokumen Paling Dilihat</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($mostViewedDocuments as $doc)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $doc->title }}</h6>
                            <small class="text-muted">{{ $doc->view_count }} kali dilihat</small>
                        </div>
                        <span class="badge bg-info">{{ $doc->view_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-history"></i> Aktivitas Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentActivities as $log)
                            <tr>
                                <td>
                                    <strong>{{ $log->user->name }}</strong><br>
                                    <small class="text-muted">{{ $log->user->email }}</small>
                                </td>
                                <td>
                                    @if(str_contains($log->action, 'document'))
                                        @if(str_contains($log->action, 'created'))
                                            <span class="badge bg-success">Upload Dokumen</span>
                                        @elseif(str_contains($log->action, 'updated'))
                                            <span class="badge bg-info">Update Dokumen</span>
                                        @elseif(str_contains($log->action, 'deleted'))
                                            <span class="badge bg-danger">Hapus Dokumen</span>
                                        @elseif(str_contains($log->action, 'downloaded'))
                                            <span class="badge bg-warning">Download Dokumen</span>
                                        @else
                                            <span class="badge bg-secondary">Lihat Dokumen</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">{{ str_replace('.', ' ', $log->action) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($documentsByCategory as $cat)
                    '{{ $cat->name }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($documentsByCategory as $cat)
                        {{ $cat->documents_count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#2563eb',
                    '#06b6d4',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6',
                    '#ec4899',
                    '#14b8a6'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Upload Trend Chart
    const trendCtx = document.getElementById('uploadTrendChart').getContext('2d');
    const trendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($documentsLast7Days as $day)
                    '{{ $day->date }}',
                @endforeach
            ],
            datasets: [{
                label: 'Dokumen Upload',
                data: [
                    @foreach($documentsLast7Days as $day)
                        {{ $day->count }},
                    @endforeach
                ],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
