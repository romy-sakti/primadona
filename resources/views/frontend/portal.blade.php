@extends('frontend.layout.app')

@section('title', 'Portal PRIMADONA')

@section('content')
    <!-- Page banner Area -->
    <div class="page-banner bg-1">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-content">
                        <h2>PRIMADONA</h2>
                        <ul>
                            <li>PELAYANAN INFORMASI PERMOHONAN PENGADILAN BERBASIS DIGITAL<br>
                                PENGADILAN NEGERI TANJUNG JABUNG TIMUR</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Service Area -->
    <div class="our-service-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <span>Layanan Kami</span>
                <h2>Kami Menyediakan <span>Layanan Terbaik</span> dengan Kemudahan dan Informasi Lengkap</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="our-service-card">
                        <i class="las la-city"></i>
                        <h3><a href="{{ route('permohonan-masyarakat') }}">Permohonan<span> Masyarakat</span></a></h3>
                        <p>Layanan pengajuan permohonan untuk masyarakat secara digital dan efisien.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="our-service-card">
                        <i class="las la-balance-scale"></i>
                        <h3><a href="{{ route('sidarling') }}">Info<span> SIDARLING</span></a></h3>
                        <p>Informasi Sidang Keliling Pengadilan Negeri Tanjung Jabung Timur.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="our-service-card">
                        <i class="las la-broadcast-tower"></i>
                        <h3><a href="{{ route('peraturan') }}">Selayang Pandang<span> Peraturan</span></a></h3>
                        <p>Peraturan Perundang-Undangan Terkait Kependudukan.</p>

                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="our-service-card">
                        <i class="las la-balance-scale-left"></i>
                        <h3><a href="{{ route('biaya') }}">Biaya<span> Permohonan</span></a></h3>
                        <p>Informasi rincian biaya layanan permohonan.</p>

                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="our-service-card">
                        <i class="las la-file-upload"></i>
                        <h3>
                            <a href="{{ Auth::check() ? route('upload-penetapan') : route('login-portal') }}">
                                Upload<span> Penetapan</span>
                            </a>
                        </h3>
                        <p>Layanan upload dokumen penetapan pengadilan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection