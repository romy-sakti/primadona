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

    @if(auth()->user()->hasRole('dukcapiltjt') && !isset($d))
    <div class="alert alert-warning">
        <div class="alert-title">{{ __('Peringatan') }}</div>
        {{ __('Anda tidak memiliki akses untuk menambah data baru.') }}
    </div>
    @else
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
                                <div class="form-group">
                                    <label>{{ __('Nama Pemohon') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->nama_pemohon ?? '' }}" />
                                    @else
                                    <input type="text" class="form-control" name="nama_pemohon" required
                                        value="{{ $d->nama_pemohon ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Jenis Permohonan') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->jenisPermohonan->nama_jenis ?? '' }}" />
                                    @else
                                    <select class="form-control select2" name="jenis_permohonan_id" required>
                                        @foreach($jenisPermohonans as $jenis)
                                        <option value="{{ $jenis->id }}" {{ isset($d) && $d->jenis_permohonan_id ==
                                            $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Nomor Perkara') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->nomor_perkara ?? '' }}" />
                                    @else
                                    <input type="text" class="form-control" name="nomor_perkara" required
                                        value="{{ $d->nomor_perkara ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Status Permohonan') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->status_permohonan ?? '' }}" />
                                    @else
                                    <select class="form-control" name="status_permohonan" required>
                                        <option value="dikabulkan" {{ isset($d) && $d->status_permohonan == 'dikabulkan'
                                            ? 'selected' : '' }}>
                                            {{ __('Dikabulkan') }}
                                        </option>
                                        <option value="ditolak" {{ isset($d) && $d->status_permohonan == 'ditolak' ?
                                            'selected' : '' }}>
                                            {{ __('Ditolak') }}
                                        </option>
                                        <option value="tidak dapat diterima" {{ isset($d) && $d->status_permohonan ==
                                            'tidak dapat diterima' ? 'selected' : '' }}>
                                            {{ __('Tidak Dapat Diterima') }}
                                        </option>
                                    </select>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Keterangan') }}</label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" name="keterangan"
                                        value="{{ $d->keterangan ?? '' }}" required />
                                    @else
                                    <input type="text" class="form-control" disabled />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Nomor Telepon') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->nomor_telepon ?? '' }}" />
                                    @else
                                    <input type="text" class="form-control" name="nomor_telepon" required
                                        value="{{ $d->nomor_telepon ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Alamat Pemohon') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->alamat_pemohon ?? '' }}" />
                                    @else
                                    <input type="text" class="form-control" name="alamat_pemohon" required
                                        value="{{ $d->alamat_pemohon ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tempat Lahir') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->tempat_lahir ?? '' }}" />
                                    @else
                                    <input type="text" class="form-control" name="tempat_lahir" required
                                        value="{{ $d->tempat_lahir ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Tanggal Lahir') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="date" class="form-control" disabled
                                        value="{{ $d->tanggal_lahir ?? '' }}" />
                                    @else
                                    <input type="date" class="form-control" name="tanggal_lahir" required
                                        value="{{ $d->tanggal_lahir ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Dokumen Penetapan') }} <span class="text-danger">*</span></label>
                                    @if(auth()->user()->hasRole('dukcapiltjt') && isset($d))
                                    <input type="text" class="form-control" disabled
                                        value="{{ $d->dokumen_penetapan ?? '' }}" />
                                    @else
                                    <input type="text" class="form-control" name="dokumen_penetapan" required
                                        value="{{ $d->dokumen_penetapan ?? '' }}" />
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>

                                @csrf

                                @if(!auth()->user()->hasRole('dukcapiltjt') || (auth()->user()->hasRole('dukcapiltjt')
                                && isset($d)))
                                @include('stisla.includes.forms.buttons.btn-save')
                                @include('stisla.includes.forms.buttons.btn-reset')
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    @endif
</div>
@endsection

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .form-control-plaintext:focus {
        outline: none !important;
        box-shadow: none !important;
        background-color: #e9ecef !important;
    }

    .form-control-plaintext:disabled,
    .form-control-plaintext[readonly] {
        background-color: #e9ecef !important;
        opacity: 1;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>
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

    // Pastikan ini dijalankan setelah dokumen dimuat
    $(document).ready(function() {
        @if(!auth()->user()->hasRole('dukcapiltjt'))
            const keteranganInput = $('#keterangan');
            keteranganInput.on('keydown paste input click focus', function(e) {
                e.preventDefault();
                return false;
            });

            keteranganInput.bind('cut copy paste', function(e) {
                e.preventDefault();
            });
        @endif
    });
</script>
@endpush
