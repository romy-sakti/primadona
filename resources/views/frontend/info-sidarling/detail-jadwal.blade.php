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
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="card-title position-relative d-inline-block">
                        <span class="position-relative">Informasi Jadwal Sidang</span>
                        <div class="title-underline"></div>
                    </h4>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="info-box p-4 mb-4">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-6">
                                    <div class="date-time-box text-center p-3 mb-3 mb-md-0">
                                        <div class="date-display">
                                            <i class="las la-calendar-alt fa-2x text-primary mb-2"></i>
                                            <h5 class="mb-1">{{ \Carbon\Carbon::parse($jadwal->tanggal_sidang)->format('d M Y') }}</h5>
                                            <p class="mb-0 text-muted">
                                                <i class="las la-clock"></i> 
                                                {{ $jadwal->jam ? \Carbon\Carbon::parse($jadwal->jam)->format('H:i') : '00:00' }} WIB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="location-box text-center p-3">
                                        <i class="las la-map-marker-alt fa-2x text-danger mb-2"></i>
                                        <h5 class="mb-1">Lokasi Sidang</h5>
                                        <p class="mb-0">{{ $jadwal->tempat_sidang }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-info">
                                <div class="info-item d-flex align-items-center p-3 border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-user text-info fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="text-muted mb-1">Nama Pemohon</label>
                                        <h6 class="mb-0">{{ $jadwal->nama_pemohon }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3 border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-gavel text-warning fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="text-muted mb-1">Hakim</label>
                                        <h6 class="mb-0">{{ $jadwal->hakim }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3 border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-user-tie text-success fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="text-muted mb-1">Panitera</label>
                                        <h6 class="mb-0">{{ $jadwal->panitera_pengganti }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3 border-bottom">
                                    <div class="icon-box me-3">
                                        <i class="las la-file-alt text-primary fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="text-muted mb-1">Nomor Perkara</label>
                                        <h6 class="mb-0">{{ $jadwal->nomor_perkara }}</h6>
                                    </div>
                                </div>

                                <div class="info-item d-flex align-items-center p-3">
                                    <div class="icon-box me-3">
                                        <i class="las la-tasks text-danger fa-2x"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="text-muted mb-1">Agenda Sidang</label>
                                        <h6 class="mb-0">{{ $jadwal->agenda_sidang }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('all-jadwal-sidarling') }}" class="btn btn-primary">
                                <i class="las la-arrow-left me-2"></i>Kembali ke Daftar Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
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
