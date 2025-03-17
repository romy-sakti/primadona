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
                                'id'=>'judul', 'name'=>'judul', 'label'=>__('Judul')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'nomor_peraturan', 'name'=>'nomor_peraturan', 'label'=>__('Nomor Peraturan')])
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun">{{ __('Tahun') }}</label>
                                    <select class="form-control" id="tahun" name="tahun" required>
                                        @for($i = date('Y'); $i >= 1945; $i--)
                                        <option value="{{ $i }}" {{ isset($d) && $d->tahun == $i ? 'selected' : '' }}>{{
                                            $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'keterangan', 'name'=>'keterangan', 'label'=>__('Keterangan')])
                            </div>

                            <div class="col-md-12">
                                @include('stisla.includes.forms.inputs.input', [
                                'required' => true,
                                'type' => 'file',
                                'id' => 'file_peraturan',
                                'name' => 'file_peraturan',
                                'label' => __('File Peraturan'),
                                'accept' => '.pdf,.doc,.docx',
                                'help' => 'Format file yang diizinkan: PDF, DOC, DOCX. Maksimal 10MB'
                                ])

                                @isset($d)
                                @if($d->file_peraturan)
                                <div class="mt-2">
                                    <p>File saat ini: {{ $d->file_peraturan }}</p>
                                </div>
                                @endif
                                @endisset
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

@endpush