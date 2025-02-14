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
                                    <textarea class="form-control tinymce @error('konten') is-invalid @enderror"
                                        id="konten" name="konten"
                                        required>{{ isset($data) ? $data->konten : old('konten') }}</textarea>
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
<link rel="stylesheet" href="{{ asset('library/tinymce/js/tinymce/skins/ui/oxide/skin.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('library/tinymce/js/tinymce/tinymce.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    tinymce.init({
    selector: '.tinymce',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    height: 500,
    promotion: false,
    branding: false
});
</script>
@endpush
