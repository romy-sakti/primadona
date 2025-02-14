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
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-primary text-white rounded-circle p-3 me-3">
                                <i class="las la-calendar-alt fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ \Carbon\Carbon::parse($item->tanggal_sidang)->format('d M
                                    Y') }}</h6>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_sidang)->format('H:i')
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
                            <a href="{{ route('jadwal-sidarling.detail', $item->id) }}" class="btn btn-info btn-sm">
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
                        <p class="text-muted mt-3 mb-0">Tidak ada jadwal sidang keliling yang tersedia saat ini.</p>
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
