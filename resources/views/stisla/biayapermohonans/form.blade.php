@extends('stisla.layouts.app')

@section('title')
{{ $fullTitle }}
@endsection

@section('content')
@include('stisla.includes.breadcrumbs.breadcrumb-form')

<div class="section-body">

    <h2 class="section-title">{{ $fullTitle }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan form ' . $title) }}.</p>

    {{-- gunakan jika ingin menampilkan sesuatu informasi --}}
    {{-- <div class="alert alert-info alert-has-icon">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
            <div class="alert-title">{{ __('Informasi') }}</div>
            This is a info alert.
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-"></i> {{ $fullTitle }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">

                        @isset($d)
                        @method('PUT')
                        @endisset

                        <div class="row">
                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'text',
                                'id' => 'biaya_pendaftaran',
                                'name' => 'biaya_pendaftaran',
                                'label' => __('Biaya Pendaftaran'),
                                'value' => $d->biaya_pendaftaran ?? ''
                                ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'text',
                                'id' => 'biaya_atk_administrasi',
                                'name' => 'biaya_atk_administrasi',
                                'label' => __('Biaya ATK / Administrasi'),
                                'value' => $d->biaya_atk_administrasi ?? ''
                                ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'text',
                                'id' => 'pnbp_panggilan',
                                'name' => 'pnbp_panggilan',
                                'label' => __('PNBP Panggilan'),
                                'value' => $d->pnbp_panggilan ?? ''
                                ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'text',
                                'id' => 'materai',
                                'name' => 'materai',
                                'label' => __('Materai'),
                                'value' => $d->materai ?? ''
                                ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'text',
                                'id' => 'redaksi',
                                'name' => 'redaksi',
                                'label' => __('Redaksi'),
                                'value' => $d->redaksi ?? ''
                                ])
                            </div>

                            <div class="col-md-12">
                                <br>

                                @csrf

                                @include('stisla.includes.forms.buttons.btn-save')
                                @include('stisla.includes.forms.buttons.btn-reset')
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('css')

@endpush

@push('js')
{{-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script> --}}
<script>
    $(document).ready(function() {
    // Fungsi untuk format Rupiah
    function formatRupiah(input) {
        $(input).on('input', function() {
            let value = $(this).val().replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value);
                $(this).val('Rp' + value.toLocaleString('id-ID'));
            }
        });

        // Format nilai awal jika ada
        if ($(input).val()) {
            let value = $(input).val().replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value);
                $(input).val('Rp' + value.toLocaleString('id-ID'));
            }
        }
    }

    // Terapkan format Rupiah ke semua input
    formatRupiah('#biaya_pendaftaran');
    formatRupiah('#biaya_atk_administrasi');
    formatRupiah('#pnbp_panggilan');
    formatRupiah('#materai');
    formatRupiah('#redaksi');
});
</script>
@endpush
