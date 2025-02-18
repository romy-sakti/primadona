@extends('frontend.layout.app')

@section('title', 'Upload Penetapan - PRIMADONA')

@section('content')
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Upload Penetapan</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li>Upload Penetapan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="services-details-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Ketentuan Penetapan -->
            <div class="col-12 mb-5">
                <div class="services-details">
                    <div class="services-details-content">
                        <h3>Ketentuan Penetapan</h3>
                        @if(!empty($ketentuan))
                        @foreach($ketentuan as $item)
                        <div class="mb-4">
                            {!! $item->konten !!}
                        </div>
                        @endforeach
                        @else
                        <div class="alert alert-info">
                            Belum ada data ketentuan penetapan.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Upload -->
            <div class="col-12">
                <div class="services-details">
                    <div class="services-details-content">
                        <h3>Form Upload Penetapan</h3>
                        <p>Silahkan upload dokumen penetapan pengadilan dengan mengisi form di bawah ini.</p>

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="las la-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body p-4">
                                <form action="{{ route('upload-penetapan.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">
                                                    Nomor Perkara <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('nomor_perkara') is-invalid @enderror"
                                                    name="nomor_perkara" value="{{ old('nomor_perkara') }}"
                                                    placeholder="Masukkan nomor perkara" required>
                                                @error('nomor_perkara')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">
                                                    File Penetapan <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="file"
                                                        class="form-control @error('file_penetapan') is-invalid @enderror"
                                                        name="file_penetapan" accept="application/pdf" required>
                                                    <span class="input-group-text bg-light">
                                                        <i class="las la-file-pdf"></i>
                                                    </span>
                                                </div>
                                                <small class="text-muted">Format file: PDF, Maksimal ukuran: 2MB</small>
                                                @error('file_penetapan')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="default-btn">
                                                <i class="las la-upload"></i> Upload Penetapan
                                            </button>
                                            <button type="reset" class="default-btn btn-secondary ms-2">
                                                <i class="las la-redo-alt"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .services-details-content {
        margin-bottom: 50px;
    }

    .form-label {
        margin-bottom: 0.5rem;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border-color: #e9ecef;
    }

    .form-control:focus {
        border-color: #c8242f;
        box-shadow: 0 0 0 0.2rem rgba(200, 36, 47, 0.25);
    }

    .input-group-text {
        border-color: #e9ecef;
    }

    .default-btn {
        background-color: #c8242f;
        border-color: #c8242f;
        color: #fff;
        padding: 12px 25px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .default-btn:hover {
        background-color: #a61d26;
        border-color: #a61d26;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .alert {
        border: none;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
