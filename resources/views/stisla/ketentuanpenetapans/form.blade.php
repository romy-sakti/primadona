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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="konten">{{ __('Ketentuan') }} <span class="text-danger">*</span></label>
                                    <textarea name="konten" id="editor"
                                        class="form-control @error('konten') is-invalid @enderror">{{ isset($d) ? $d->konten : old('konten') }}</textarea>
                                    @error('konten')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor {
        margin-bottom: 10px;
    }

    .note-editor.note-frame {
        border: 1px solid #ddd;
    }

    .note-editor.note-frame .note-editing-area .note-editable {
        min-height: 300px;
        background: #fff;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Times New Roman'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36']
        });
    });
</script>
@endpush
