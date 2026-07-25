@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
<div class="mb-4">
    <h1 class="page-title mb-1">Log Aktivitas</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Activity Log</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($logs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                            <th>Model</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>
                                <small class="text-muted">{{ $log->created_at->format('d M Y H:i:s') }}</small>
                            </td>
                            <td>
                                <strong>{{ $log->user->name }}</strong><br>
                                <small class="text-muted">{{ $log->user->email }}</small>
                            </td>
                            <td>
                                @if(str_contains($log->action, 'created'))
                                    <span class="badge bg-success"><i class="fas fa-plus"></i> Buat</span>
                                @elseif(str_contains($log->action, 'updated'))
                                    <span class="badge bg-info"><i class="fas fa-edit"></i> Update</span>
                                @elseif(str_contains($log->action, 'deleted'))
                                    <span class="badge bg-danger"><i class="fas fa-trash"></i> Hapus</span>
                                @elseif(str_contains($log->action, 'downloaded'))
                                    <span class="badge bg-warning"><i class="fas fa-download"></i> Download</span>
                                @elseif(str_contains($log->action, 'viewed'))
                                    <span class="badge bg-secondary"><i class="fas fa-eye"></i> Lihat</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ str_replace('.', ' ', $log->action) }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $log->model }}</small><br>
                                <small class="text-muted">ID: {{ $log->model_id }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $log->ip_address ?? '-' }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $logs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 48px; color: #d1d5db;"></i>
                <p class="text-muted mt-3 mb-0">Belum ada aktivitas</p>
            </div>
        @endif
    </div>
</div>

@endsection
