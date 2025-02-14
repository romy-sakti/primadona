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
                        <li><a href="{{ route('sidarling') }}">Info SIDARLING <i class="las la-angle-right"></i></a>
                        </li>
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Informasi Jadwal Sidang</h4>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><i class="las la-calendar"></i> Tanggal</td>
                                <td>: {{ \Carbon\Carbon::parse($jadwal->tanggal_sidang)->format('d M Y H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td><i class="las la-user"></i> Nama Pemohon</td>
                                <td>: {{ $jadwal->nama_pemohon }}</td>
                            </tr>
                            <tr>
                                <td><i class="las la-map-marker"></i> Tempat</td>
                                <td>: {{ $jadwal->tempat_sidang }}</td>
                            </tr>
                            <tr>
                                <td><i class="las la-gavel"></i> Hakim</td>
                                <td>: {{ $jadwal->hakim }}</td>
                            </tr>
                            <tr>
                                <td><i class="las la-user-tie"></i> Panitera</td>
                                <td>: {{ $jadwal->panitera_pengganti }}</td>
                            </tr>
                            <tr>
                                <td><i class="las la-file-alt"></i> No. Perkara</td>
                                <td>: {{ $jadwal->nomor_perkara }}</td>
                            </tr>
                            <tr>
                                <td><i class="las la-tasks"></i> Agenda</td>
                                <td>: {{ $jadwal->agenda_sidang }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('sidarling') }}" class="btn btn-primary">
                        <i class="las la-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
