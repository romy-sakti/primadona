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
                                'type' => 'date',
                                'id' => 'tanggal_sidang',
                                'name' => 'tanggal_sidang',
                                'label' => __('Tanggal Sidang'),
                                'value' => isset($d) ? date('Y-m-d', strtotime($d->tanggal_sidang)) : ''
                                ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'time',
                                'id' => 'jam',
                                'name' => 'jam',
                                'label' => __('Jam Sidang'),
                                'value' => isset($d) ? $d->jam : ''
                                ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'nama_pemohon', 'name'=>'nama_pemohon', 'label'=>__('Nama Pemohon')])
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_sidang">{{ __('Tempat Sidang') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" id="tempat_sidang" name="tempat_sidang"
                                        required>
                                        <option value="" disabled selected>-- Pilih Kecamatan --</option>
                                        <option value="Muara Sabak Barat" {{ isset($d) && $d->tempat_sidang === 'Muara
                                            Sabak Barat' ? 'selected' : '' }}>Muara Sabak Barat</option>
                                        <option value="Muara Sabak Timur" {{ isset($d) && $d->tempat_sidang === 'Muara
                                            Sabak Timur' ? 'selected' : '' }}>Muara Sabak Timur</option>
                                        <option value="Mendahara" {{ isset($d) && $d->tempat_sidang === 'Mendahara' ?
                                            'selected' : '' }}>Mendahara</option>
                                        <option value="Mendahara Ulu" {{ isset($d) && $d->tempat_sidang === 'Mendahara
                                            Ulu' ? 'selected' : '' }}>Mendahara Ulu</option>
                                        <option value="Kuala Jambi" {{ isset($d) && $d->tempat_sidang === 'Kuala Jambi'
                                            ? 'selected' : '' }}>Kuala Jambi</option>
                                        <option value="Rantau Rasau" {{ isset($d) && $d->tempat_sidang === 'Rantau
                                            Rasau' ? 'selected' : '' }}>Rantau Rasau</option>
                                        <option value="Berbak" {{ isset($d) && $d->tempat_sidang === 'Berbak' ?
                                            'selected' : '' }}>Berbak</option>
                                        <option value="Nipah Panjang" {{ isset($d) && $d->tempat_sidang === 'Nipah
                                            Panjang' ? 'selected' : '' }}>Nipah Panjang</option>
                                        <option value="Sadu" {{ isset($d) && $d->tempat_sidang === 'Sadu' ? 'selected' :
                                            '' }}>Sadu</option>
                                        <option value="Dendang" {{ isset($d) && $d->tempat_sidang === 'Dendang' ?
                                            'selected' : '' }}>Dendang</option>
                                        <option value="Geragai" {{ isset($d) && $d->tempat_sidang === 'Geragai' ?
                                            'selected' : '' }}>Geragai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'agenda_sidang', 'name'=>'agenda_sidang', 'label'=>__('Agenda Sidang')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'hakim', 'name'=>'hakim', 'label'=>__('Hakim')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'panitera_pengganti', 'name'=>'panitera_pengganti', 'label'=>__('Panitera
                                Pengganti')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'nomor_perkara', 'name'=>'nomor_perkara', 'label'=>__('Nomor Perkara')])
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
<link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush