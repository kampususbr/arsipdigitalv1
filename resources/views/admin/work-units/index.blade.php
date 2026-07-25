@extends('layouts.app')

@section('title', 'Unit Kerja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Unit Kerja</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Unit Kerja</li>
            </ol>
        </nav>
    </div>
    @can('workunit.create')
    <a href="{{ route('admin.work-units.create') }}" class="btn btn-primary btn-custom">
        <i class="fas fa-plus"></i> Tambah Unit Kerja
    </a>
    @endcan
</div>

<div class="card">
    <div class="card-body p-0">
        @if($units->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Unit</th>
                            <th>Kepala Unit</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                        <tr>
                            <td>
                                <strong>{{ $unit->name }}</strong><br>
                                <small class="text-muted">{{ Str::limit($unit->description, 50) }}</small>
                            </td>
                            <td>
                                <small>{{ $unit->head_name ?? '-' }}</small><br>
                                <small class="text-muted">{{ $unit->head_email ?? '-' }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $unit->phone ?? '-' }}</small>
                            </td>
                            <td>
                                @if($unit->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('workunit.update')
                                    <a href="{{ route('admin.work-units.edit', $unit) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('workunit.delete')
                                    <form method="POST" action="{{ route('admin.work-units.destroy', $unit) }}" style="display: inline;" onsubmit="confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $units->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 48px; color: #d1d5db;"></i>
                <p class="text-muted mt-3 mb-0">Tidak ada unit kerja</p>
            </div>
        @endif
    </div>
</div>

@endsection
