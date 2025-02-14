@extends('frontend.layout.app')

@section('title', 'Info SIDARLING - PRIMADONA')

@section('content')
<!-- Page Banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Info SIDARLING</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li>Info SIDARLING</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Details Area -->
<div class="services-details-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="services-details">
                    <!-- Narasi Section -->
                    <div class="services-details-content">
                        <h3>Informasi Sidang Keliling</h3>

                        @forelse($narasi as $item)
                        <div class="single-narasi mb-5">
                            <h4 class="mb-3">Tahun {{ $item->tahun }}</h4>

                            @if(!empty($item->foto) && is_array($item->foto))
                            <div class="img-gallery mb-4">
                                <div class="row g-4">
                                    @foreach($item->foto as $foto)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="gallery-item">
                                            <img src="{{ asset('storage/narasisidangkeliling/foto/' . $foto) }}"
                                                alt="Foto Sidang Keliling" class="img-fluid rounded">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="content">
                                {!! $item->narasi !!}
                            </div>

                            @if(!empty($item->dokumen) && is_array($item->dokumen))
                            <h5 class="text-dark fw-bold mb-3">FILE PENDUKUNG</h5>
                            <div class="article-footer">
                                <div class="file-list">
                                    @foreach($item->dokumen as $dokumen)
                                    <div class="file-item">
                                        <a href="{{ asset('storage/narasisidangkeliling/dokumen/' . $dokumen) }}"
                                            target="_blank" class="text-decoration-none">
                                            <span class="text-danger">- {{ pathinfo($dokumen, PATHINFO_FILENAME)
                                                }}</span>
                                            <span class="file-size">[1.8 MB]</span>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @empty
                        <p class="text-center">Tidak ada informasi sidang keliling yang tersedia saat ini.</p>
                        @endforelse

                        <!-- Narasi Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $narasi->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    <!-- Jadwal Section -->
                    <div class="mt-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="section-title">Jadwal Sidang Keliling</h3>
                            <a href="{{ route('all-jadwal-sidarling') }}" class="btn btn-info btn-sm">
                                Lihat Semua <i class="las la-arrow-right"></i>
                            </a>
                        </div>

                        <div class="row g-4">
                            @forelse($jadwal as $item)
                            <div class="col-lg-6 col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-box bg-primary text-white rounded-circle p-3 me-3">
                                                <i class="las la-calendar-alt fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{
                                                    \Carbon\Carbon::parse($item->tanggal_sidang)->format('d M Y') }}
                                                </h6>
                                                <small class="text-muted">{{
                                                    $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') :
                                                    '00:00'
                                                    }} WIB</small>
                                            </div>
                                        </div>

                                        <div class="ps-2 border-start border-4 border-primary mb-3">
                                            <h5 class="mb-0">{{ $item->nama_pemohon }}</h5>
                                            <small class="text-muted">Pemohon</small>
                                        </div>

                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="icon-box bg-light rounded-circle p-2 me-3">
                                                    <i class="las la-map-marker text-primary"></i>
                                                </span>
                                                <span>{{ $item->tempat_sidang }}</span>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span class="icon-box bg-light rounded-circle p-2 me-3">
                                                    <i class="las la-gavel text-primary"></i>
                                                </span>
                                                <span>{{ $item->hakim }}</span>
                                            </li>
                                        </ul>

                                        <div class="mt-4 text-end">
                                            <a href="{{ route('jadwal-sidarling.detail', $item->id) }}"
                                                class="btn btn-info btn-sm">
                                                Lihat Detail <i class="las la-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center py-5">
                                        <i class="las la-calendar-times text-muted fs-1"></i>
                                        <p class="text-muted mt-3 mb-0">Tidak ada jadwal sidang keliling yang tersedia
                                            saat ini.</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
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
    .comment-author .avatar {
        font-size: 2.5em;
        margin-right: 15px;
    }

    .services-details-content {
        margin-bottom: 50px;
    }

    .article-footer {
        margin-top: 30px;
    }

    .article-tags {
        border-left: 4px solid var(--main-color);
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .article-tags:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-primary {
        border: 1px solid var(--main-color);
        color: var(--main-color);
        transition: all 0.3s ease;
        border-radius: 20px;
        padding: 6px 15px;
    }

    .btn-outline-primary:hover {
        background-color: var(--main-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .gap-3 {
        gap: 1rem !important;
    }

    .file-list {
        margin-left: 10px;
    }

    .file-item {
        margin-bottom: 10px;
    }

    .file-item a {
        color: inherit;
    }

    .file-item a:hover .text-danger {
        text-decoration: underline;
    }

    .file-size {
        font-size: 14px;
        color: #000;
    }

    .gallery-item {
        height: 250px;
        overflow: hidden;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    /* Pagination Styling */
    .pagination {
        margin: 0;
    }

    .page-link {
        color: var(--main-color);
        border: 1px solid var(--main-color);
        padding: 8px 15px;
        margin: 0 3px;
        border-radius: 5px;
    }

    .page-link:hover {
        background-color: var(--main-color);
        color: white;
    }

    .page-item.active .page-link {
        background-color: var(--main-color);
        border-color: var(--main-color);
    }

    /* Separator between items */
    .single-narasi:not(:last-child) {
        border-bottom: 1px solid #eee;
        padding-bottom: 30px;
    }

    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
    }

    .icon-box i {
        font-size: 1.5rem;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Custom color */
    .bg-primary {
        background-color: #c8242f !important;
    }

    .text-primary {
        color: #c8242f !important;
    }

    .border-primary {
        border-color: #c8242f !important;
    }

    .btn-info {
        background-color: #c8242f;
        border-color: #c8242f;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #a61d26;
        border-color: #a61d26;
        color: #fff;
    }
</style>
@endpush
