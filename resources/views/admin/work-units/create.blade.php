@extends('layouts.app')

@section('title', 'Tambah Unit Kerja')

@section('content')
<div class="mb-4">
    <h1 class="page-title mb-1">Tambah Unit Kerja Baru</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.work-units.index') }}">Unit Kerja</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-plus"></i> Form Unit Kerja Baru</h5>
            </div>
            <form method="POST" action="{{ route('admin.work-units.store') }}" class="card-body">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Unit Kerja <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Contoh: Biro Administrasi" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Masukkan deskripsi unit kerja">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="head_name" class="form-label">Nama Kepala Unit</label>
                    <input type="text" class="form-control @error('head_name') is-invalid @enderror" id="head_name" name="head_name" placeholder="Nama kepala/pimpinan unit" value="{{ old('head_name') }}">
                    @error('head_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="head_email" class="form-label">Email Kepala Unit</label>
                    <input type="email" class="form-control @error('head_email') is-invalid @enderror" id="head_email" name="head_email" placeholder="email@example.com" value="{{ old('head_email') }}">
                    @error('head_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Contoh: 0274-511414" value="{{ old('phone') }}">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sort_order" class="form-label">Urutan</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" placeholder="0" value="{{ old('sort_order', 0) }}">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" @if(old('status') == 'active') selected @endif>Aktif</option>
                            <option value="inactive" @if(old('status') == 'inactive') selected @endif>Nonaktif</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-custom flex-grow-1">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.work-units.index') }}" class="btn btn-outline-secondary btn-custom">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
