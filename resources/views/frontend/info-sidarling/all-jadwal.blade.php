@extends('frontend.layout.app')

@section('title', 'Semua Jadwal Sidang Keliling - PRIMADONA')

@section('content')
<!-- Page Banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Jadwal Sidang Keliling</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li><a href="{{ route('sidarling') }}">Info SIDARLING <i class="las la-angle-right"></i></a>
                        </li>
                        <li>Semua Jadwal</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal List Area -->
<div class="services-details-area ptb-100">
    <div class="container">
        <div class="row g-4">
            @forelse($jadwal as $item)
            <div class="col-lg-6 col-md-6">
                <div class="card h-100 border-0 theme-card">
                    <div class="card-body theme-card-body">
                        <!-- Tanggal dan Waktu -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box theme-primary-box rounded-circle p-3 me-3">
                                <i class="las la-calendar-alt fs-4 theme-primary-icon"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 theme-heading">{{ \Carbon\Carbon::parse($item->tanggal_sidang)->format('d M Y') }}</h6>
                                <small class="theme-secondary-text">{{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') : '00:00' }} WIB</small>
                            </div>
                        </div>

                        <!-- Nama Pemohon -->
                        <div class="ps-2 theme-border-accent mb-3">
                            <h5 class="mb-0 theme-heading">{{ $item->nama_pemohon }}</h5>
                            <small class="theme-secondary-text">Pemohon</small>
                        </div>

                        <!-- Informasi Detail -->
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-3">
                                <span class="icon-box theme-secondary-box rounded-circle p-2 me-3">
                                    <i class="las la-map-marker theme-accent-icon"></i>
                                </span>
                                <span class="theme-text">{{ $item->tempat_sidang }}</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="icon-box theme-secondary-box rounded-circle p-2 me-3">
                                    <i class="las la-gavel theme-accent-icon"></i>
                                </span>
                                <span class="theme-text">{{ $item->hakim }}</span>
                            </li>
                        </ul>

                        <!-- Tombol Detail -->
                        <div class="mt-4 text-end">
                            <a href="{{ route('jadwal-sidarling.detail', $item->id) }}" class="btn theme-button btn-sm">
                                <span class="theme-button-text">Lihat Detail</span> 
                                <i class="las la-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 theme-card">
                    <div class="card-body text-center py-5 theme-card-body">
                        <i class="las la-calendar-times theme-secondary-text fs-1"></i>
                        <p class="theme-secondary-text mt-3 mb-0">Tidak ada jadwal sidang keliling yang tersedia saat ini.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $jadwal->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Base Styles */
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
    }

    /* Theme Light */
    .theme-light .theme-card {
        background: #ffffff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .theme-light .theme-card-body {
        background: #ffffff;
    }
    .theme-light .theme-heading {
        color: #2d3436;
    }
    .theme-light .theme-text {
        color: #2d3436;
    }
    .theme-light .theme-secondary-text {
        color: #636e72;
    }
    .theme-light .theme-primary-box {
        background: #c8242f;
    }
    .theme-light .theme-primary-icon {
        color: #ffffff;
    }
    .theme-light .theme-secondary-box {
        background: #f5f6fa;
    }
    .theme-light .theme-accent-icon {
        color: #c8242f;
    }
    .theme-light .theme-border-accent {
        border-left: 4px solid #c8242f;
    }
    .theme-light .theme-button {
        background: #c8242f;
        border: none;
    }
    .theme-light .theme-button-text {
        color: #ffffff;
    }
    .theme-light .theme-button:hover {
        background: #a61d26;
    }

    /* Theme Dark */
    .theme-dark .theme-card {
        background: #2d3436;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    .theme-dark .theme-card-body {
        background: #2d3436;
    }
    .theme-dark .theme-heading {
        color: #ffffff;
    }
    .theme-dark .theme-text {
        color: #dfe6e9;
    }
    .theme-dark .theme-secondary-text {
        color: #b2bec3;
    }
    .theme-dark .theme-primary-box {
        background: #c8242f;
    }
    .theme-dark .theme-primary-icon {
        color: #ffffff;
    }
    .theme-dark .theme-secondary-box {
        background: #404b4d;
    }
    .theme-dark .theme-accent-icon {
        color: #ff7675;
    }
    .theme-dark .theme-border-accent {
        border-left: 4px solid #ff7675;
    }
    .theme-dark .theme-button {
        background: #c8242f;
        border: none;
    }
    .theme-dark .theme-button-text {
        color: #ffffff;
    }
    .theme-dark .theme-button:hover {
        background: #a61d26;
    }

    /* Pagination Theme Support */
    .theme-dark .page-link {
        background-color: #2d3436;
        border-color: #404b4d;
        color: #dfe6e9;
    }
    .theme-dark .page-item.active .page-link {
        background-color: #c8242f;
        border-color: #c8242f;
        color: #ffffff;
    }
    .theme-dark .page-item.disabled .page-link {
        background-color: #404b4d;
        border-color: #404b4d;
        color: #b2bec3;
    }
</style>
@endpush
