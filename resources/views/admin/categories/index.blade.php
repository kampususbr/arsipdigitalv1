@extends('layouts.app')

@section('title', 'Kategori Dokumen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Kategori</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kategori</li>
            </ol>
        </nav>
    </div>
    @can('category.create')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-custom">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
    @endcan
</div>

<div class="card">
    <div class="card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <strong><i class="{{ $category->icon ?? 'fa-folder' }}"></i> {{ $category->name }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $category->documents_count }}</span>
                            </td>
                            <td>
                                @if($category->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('category.update')
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('category.delete')
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;" onsubmit="confirmDelete(event)">
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
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 48px; color: #d1d5db;"></i>
                <p class="text-muted mt-3 mb-0">Tidak ada kategori</p>
            </div>
        @endif
    </div>
</div>

@endsection
