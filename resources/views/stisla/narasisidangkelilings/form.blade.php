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
                                'id'=>'tahun', 'name'=>'tahun', 'label'=>__('Tahun')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'narasi', 'name'=>'narasi', 'label'=>__('Narasi')])
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Foto') }}</label>

                                    @if(isset($d) && $d->foto)
                                    <div class="mb-3">
                                        <label>Foto yang sudah ada:</label>
                                        <div class="row">
                                            @foreach($d->foto as $index => $foto)
                                            <div class="col-md-3 mb-3">
                                                <div class="card">
                                                    <img src="{{ asset('storage/narasisidangkeliling/foto/' . $foto) }}"
                                                        class="card-img-top" alt="Foto">
                                                    <div class="card-body">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-block hapus-foto-lama"
                                                            data-foto="{{ $foto }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                        <input type="hidden" name="foto_lama[]" value="{{ $foto }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <div id="foto-container">
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" name="foto[]" accept="image/*">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger hapus-foto"
                                                    style="display:none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" id="tambah-foto">
                                        <i class="fas fa-plus"></i> Tambah Foto
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Dokumen') }}</label>

                                    @if(isset($d) && $d->dokumen)
                                    <div class="mb-3">
                                        <label>Dokumen yang sudah ada:</label>
                                        <div class="row">
                                            @foreach($d->dokumen as $index => $dokumen)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-text">{{ $dokumen }}</p>
                                                        <a href="{{ asset('storage/narasisidangkeliling/dokumen/' . $dokumen) }}"
                                                            class="btn btn-info btn-sm" target="_blank">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm hapus-dokumen-lama"
                                                            data-dokumen="{{ $dokumen }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                        <input type="hidden" name="dokumen_lama[]"
                                                            value="{{ $dokumen }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <div id="dokumen-container">
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" name="dokumen[]"
                                                accept=".pdf,.doc,.docx">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger hapus-dokumen"
                                                    style="display:none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" id="tambah-dokumen">
                                        <i class="fas fa-plus"></i> Tambah Dokumen
                                    </button>
                                </div>
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
<script>
    $(document).ready(function() {
    // Fungsi untuk foto
    $('#tambah-foto').click(function() {
        var newInput = `
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="foto[]" accept="image/*">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger hapus-foto">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#foto-container').append(newInput);
        toggleHapusFotoButtons();
    });

    $(document).on('click', '.hapus-foto', function() {
        $(this).closest('.input-group').remove();
        toggleHapusFotoButtons();
    });

    function toggleHapusFotoButtons() {
        if ($('#foto-container .input-group').length > 1) {
            $('.hapus-foto').show();
        } else {
            $('.hapus-foto').hide();
        }
    }

    // Fungsi untuk dokumen
    $('#tambah-dokumen').click(function() {
        var newInput = `
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="dokumen[]" accept=".pdf,.doc,.docx">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger hapus-dokumen">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#dokumen-container').append(newInput);
        toggleHapusDokumenButtons();
    });

    $(document).on('click', '.hapus-dokumen', function() {
        $(this).closest('.input-group').remove();
        toggleHapusDokumenButtons();
    });

    function toggleHapusDokumenButtons() {
        if ($('#dokumen-container .input-group').length > 1) {
            $('.hapus-dokumen').show();
        } else {
            $('.hapus-dokumen').hide();
        }
    }

    // Fungsi untuk menghapus foto lama
    $('.hapus-foto-lama').click(function() {
        $(this).closest('.col-md-3').remove();
    });

    // Fungsi untuk menghapus dokumen lama
    $('.hapus-dokumen-lama').click(function() {
        $(this).closest('.col-md-4').remove();
    });
});
</script>
@endpush
