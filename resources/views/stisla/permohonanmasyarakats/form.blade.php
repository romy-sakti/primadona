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
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'nama_pemohon', 'name'=>'nama_pemohon', 'label'=>__('Nama Pemohon')])
                            </div>

                            <div class="col-md-6">
                                <label for="jenis_permohonan_id">{{ __('Jenis Permohonan') }}</label>
                                <select class="form-control select2" id="jenis_permohonan_id" name="jenis_permohonan_id"
                                    required>
                                    @foreach($jenisPermohonans as $jenis)
                                    <option value="{{ $jenis->id }}" {{ (isset($d) && $d->jenis_permohonan_id ==
                                        $jenis->id) ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'nomor_perkara', 'name'=>'nomor_perkara', 'label'=>__('Nomor Perkara')])
                            </div>

                            <div class="col-md-6">
                                <label for="status_permohonan">{{ __('Status Permohonan') }}</label>
                                <select class="form-control" id="status_permohonan" name="status_permohonan" required>
                                    <option value="dikabulkan" {{ (isset($d) && $d->status_permohonan == 'dikabulkan') ?
                                        'selected' : '' }}>
                                        {{ __('Dikabulkan') }}
                                    </option>
                                    <option value="ditolak" {{ (isset($d) && $d->status_permohonan == 'ditolak') ?
                                        'selected' : '' }}>
                                        {{ __('Ditolak') }}
                                    </option>
                                    <option value="tidak dapat diterima" {{ (isset($d) && $d->status_permohonan ==
                                        'tidak dapat diterima') ? 'selected' : '' }}>
                                        {{ __('Tidak Dapat Diterima') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'keterangan', 'name'=>'keterangan', 'label'=>__('Keterangan')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'dokumen_penetapan', 'name'=>'dokumen_penetapan', 'label'=>__('Dokumen
                                Penetapan')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'number',
                                'id' => 'nomor_telepon',
                                'name' => 'nomor_telepon',
                                'label' => __('Nomor Telp'),
                                'attributes' => [
                                'min' => '0',
                                'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 'maxlength'=>
                                    '13'
                                    ]
                                    ])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'alamat_pemohon', 'name'=>'alamat_pemohon', 'label'=>__('Alamat')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'tempat_lahir', 'name'=>'tempat_lahir', 'label'=>__('Tempat Lahir')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'date',
                                'id' => 'tanggal_lahir',
                                'name' => 'tanggal_lahir',
                                'label' => __('Tanggal lahir')
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    document.getElementById('nomor_telepon').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 13) {
            this.value = this.value.slice(0, 13);
        }
    });
</script>
@endpush
