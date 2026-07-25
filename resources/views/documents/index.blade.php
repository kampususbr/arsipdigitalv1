@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Dokumen</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Dokumen</li>
            </ol>
        </nav>
    </div>
    @can('document.create')
    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-custom">
        <i class="fas fa-plus"></i> Upload Dokumen
    </a>
    @endcan
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('documents.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari judul, nomor, atau deskripsi dokumen..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Documents List -->
<div class="card">
    <div class="card-body p-0">
        @if($documents->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Diupload</th>
                            <th>Ukuran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                        <tr>
                            <td>
                                <strong>{{ $document->title }}</strong><br>
                                <small class="text-muted">No: {{ $document->document_number ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="{{ $document->category->icon ?? 'fa-folder' }}"></i>
                                    {{ $document->category->name }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $document->created_at->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ $document->creator->name }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $document->getFileSizeFormatted() }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $document->created_by)
                                    <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->can('document.delete'))
                                    <form method="POST" action="{{ route('documents.destroy', $document) }}" style="display: inline;" onsubmit="confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-light">
                {{ $documents->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 48px; color: #d1d5db;"></i>
                <p class="text-muted mt-3 mb-0">Tidak ada dokumen yang ditemukan</p>
            </div>
        @endif
    </div>
</div>

@endsection
