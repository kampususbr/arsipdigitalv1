@extends('layouts.app')

@section('title', $document->title)

@section('content')
<div class="mb-4">
    <h1 class="page-title mb-1">{{ $document->title }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
            <li class="breadcrumb-item active">{{ $document->title }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-pdf"></i> Detail Dokumen</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Deskripsi</h6>
                    <p>{{ $document->description ?? 'Tidak ada deskripsi' }}</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Kategori</h6>
                        <p>
                            <span class="badge bg-light text-dark">
                                <i class="{{ $document->category->icon ?? 'fa-folder' }}"></i>
                                {{ $document->category->name }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Unit Kerja</h6>
                        <p>{{ $document->workUnit->name ?? 'Tidak ada unit kerja' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Nomor Dokumen</h6>
                        <p>{{ $document->document_number ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tanggal Dokumen</h6>
                        <p>{{ $document->document_date ? $document->document_date->format('d M Y') : '-' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Diupload Oleh</h6>
                        <p>{{ $document->creator->name }} ({{ $document->creator->email }})</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tanggal Upload</h6>
                        <p>{{ $document->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Ukuran File</h6>
                        <p>{{ $document->getFileSizeFormatted() }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tipe Akses</h6>
                        <p>
                            @if($document->visibility == 'public')
                                <span class="badge bg-success"><i class="fas fa-globe"></i> Public</span>
                            @elseif($document->visibility == 'restricted')
                                <span class="badge bg-warning"><i class="fas fa-lock"></i> Restricted</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-lock"></i> Private</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-chart-bar"></i> <strong>Statistik:</strong>
                    Dilihat {{ $document->view_count }} kali | Download {{ $document->download_count }} kali
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Aksi</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('documents.download', $document) }}" class="btn btn-success btn-custom w-100 mb-2">
                    <i class="fas fa-download"></i> Download
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->id === $document->created_by)
                <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning btn-custom w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endif

                @if(auth()->user()->can('document.delete'))
                <form method="POST" action="{{ route('documents.destroy', $document) }}" onsubmit="confirmDelete(event)" class="mb-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-custom w-100">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
                @endif

                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-custom w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Info File</h6>
            </div>
            <div class="card-body">
                <small class="d-block mb-2">
                    <strong>Nama File:</strong><br>
                    {{ $document->file_name }}
                </small>
                <small class="d-block mb-2">
                    <strong>Tipe File:</strong><br>
                    {{ $document->file_type }}
                </small>
                <small class="d-block">
                    <strong>Path:</strong><br>
                    <code>{{ $document->file_path }}</code>
                </small>
            </div>
        </div>
    </div>
</div>

@endsection
