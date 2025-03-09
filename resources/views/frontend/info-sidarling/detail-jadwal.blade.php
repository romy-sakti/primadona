@extends('frontend.layout.app')

@section('title', 'Detail Jadwal Sidang Keliling - PRIMADONA')

@section('content')
<!-- Page Banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Detail Jadwal Sidang Keliling</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li><a href="{{ route('sidarling') }}">Info SIDARLING <i class="las la-angle-right"></i></a></li>
                        <li>Detail Jadwal</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Jadwal Area -->
<div class="services-details-area ptb-100">
    <div class="container">
        <div class="card theme-card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="card-title position-relative d-inline-block">
                        <span class="position-relative theme-text">Informasi Jadwal Sidang</span>
                        <div class="title-underline"></div>
                    </h4>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="info-box theme-box p-4 mb-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-6">
                                    <div class="date-time-box text-center p-3 mb-3 mb-md-0 theme-box">
                                        <div class="date-display">
                                            <i class="las la-calendar-alt fa-2x text-primary mb-2"></i>
                                            <h5 class="mb-1 theme-text">{{ \Carbon\Carbon::parse($jadwal->tanggal_sidang)->format('d M Y') }}</h5>
                                            <p class="mb-0 theme-text-muted">
                                                <i class="las la-clock"></i> 
                                                {{ $jadwal->jam ? \Carbon\Carbon::parse($jadwal->jam)->format('H:i') : '00:00' }} WIB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="location-box text-center p-3 theme-box">
                                        <i class="las la-map-marker-alt fa-2x text-danger mb-2"></i>
                                        <h5 class="mb-1 theme-text">Lokasi Sidang</h5>
                                        <p class="mb-0 theme-text">{{ $jadwal->tempat_sidang }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-info">
                                <div class="info-item d-flex align-items-center p-3 theme-border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-user text-info fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="theme-text-muted mb-1">Nama Pemohon</label>
                                        <h6 class="mb-0 theme-text">{{ $jadwal->nama_pemohon }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3 theme-border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-gavel text-warning fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="theme-text-muted mb-1">Hakim</label>
                                        <h6 class="mb-0 theme-text">{{ $jadwal->hakim }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3 theme-border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-user-tie text-success fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="theme-text-muted mb-1">Panitera</label>
                                        <h6 class="mb-0 theme-text">{{ $jadwal->panitera_pengganti }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3 theme-border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-file-alt text-primary fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="theme-text-muted mb-1">Nomor Perkara</label>
                                        <h6 class="mb-0 theme-text">{{ $jadwal->nomor_perkara }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3">
                                    <div class="icon-box me-3">
                                        <i class="las la-tasks text-danger fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="theme-text-muted mb-1">Agenda Sidang</label>
                                        <h6 class="mb-0 theme-text">{{ $jadwal->agenda_sidang }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ route('all-jadwal-sidarling') }}" class="btn btn-info btn-sm theme-button">
                                <i class="las la-arrow-left"></i> Kembali
                            </a>
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
    /* Theme Light */
    .theme-light .theme-card {
        background: #fff;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .theme-light .theme-text {
        color: #333;
    }
    .theme-light .theme-text-muted {
        color: #6c757d;
    }
    .theme-light .theme-box {
        background: #f8f9fa;
    }
    .theme-light .theme-border-bottom {
        border-bottom: 1px solid #dee2e6;
    }
    .theme-light .theme-button {
        background: #17a2b8;
        color: #fff;
    }

    /* Theme Dark */
    .theme-dark .theme-card {
        background: #2a2a2a;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .theme-dark .theme-text {
        color: #fff;
    }
    .theme-dark .theme-text-muted {
        color: #adb5bd;
    }
    .theme-dark .theme-box {
        background: #343a40;
    }
    .theme-dark .theme-border-bottom {
        border-bottom: 1px solid #454d55;
    }
    .theme-dark .theme-button {
        background: #0f7a8a;
        color: #fff;
    }

    .title-underline {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: linear-gradient(to right, #007bff, #00ff88);
        border-radius: 10px;
    }

    .info-box {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }

    .date-time-box, .location-box {
        background-color: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .date-time-box:hover, .location-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .info-item {
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background-color: #f8f9fa;
    }

    .icon-box {
        width: 50px;
        text-align: center;
    }

    .info-content label {
        font-size: 0.85rem;
        font-weight: 500;
    }

    .btn-primary {
        padding: 10px 25px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    }

    @media (max-width: 768px) {
        .info-item {
            padding: 15px !important;
        }
        
        .icon-box {
            width: 40px;
        }
        
        .icon-box i {
            font-size: 1.5rem !important;
        }
    }
</style>
@endpush
