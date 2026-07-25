@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
<div class="mb-4">
    <h1 class="page-title mb-1">Upload Dokumen Baru</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Dokumen</a></li>
            <li class="breadcrumb-item active">Upload</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-upload"></i> Form Upload Dokumen</h5>
            </div>
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="card-body">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Masukkan judul dokumen" value="{{ old('title') }}" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Masukkan deskripsi dokumen (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="work_unit_id" class="form-label">Unit Kerja</label>
                        <select class="form-select @error('work_unit_id') is-invalid @enderror" id="work_unit_id" name="work_unit_id">
                            <option value="">Pilih Unit Kerja (Opsional)</option>
                            @foreach($workUnits as $unit)
                            <option value="{{ $unit->id }}" @if(old('work_unit_id') == $unit->id) selected @endif>
                                {{ $unit->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('work_unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="document_number" class="form-label">Nomor Dokumen</label>
                        <input type="text" class="form-control @error('document_number') is-invalid @enderror" id="document_number" name="document_number" placeholder="Contoh: DOC-2024-001" value="{{ old('document_number') }}">
                        @error('document_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="document_date" class="form-label">Tanggal Dokumen</label>
                        <input type="date" class="form-control @error('document_date') is-invalid @enderror" id="document_date" name="document_date" value="{{ old('document_date') }}">
                        @error('document_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="visibility" class="form-label">Akses <span class="text-danger">*</span></label>
                    <select class="form-select @error('visibility') is-invalid @enderror" id="visibility" name="visibility" required>
                        <option value="">Pilih Tipe Akses</option>
                        <option value="public" @if(old('visibility') == 'public') selected @endif>
                            <i class="fas fa-globe"></i> Public (Semua bisa akses)
                        </option>
                        <option value="restricted" @if(old('visibility') == 'restricted') selected @endif>
                            <i class="fas fa-lock"></i> Restricted (User terpilih)
                        </option>
                        <option value="private" @if(old('visibility') == 'private') selected @endif>
                            <i class="fas fa-lock"></i> Private (Hanya saya)
                        </option>
                    </select>
                    @error('visibility')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">File PDF <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf" required>
                        <span class="input-group-text"><i class="fas fa-paperclip"></i></span>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle"></i> Format: PDF | Ukuran maksimal: 5 MB
                    </small>
                    @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-custom flex-grow-1">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Dokumen
                    </button>
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-custom">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
