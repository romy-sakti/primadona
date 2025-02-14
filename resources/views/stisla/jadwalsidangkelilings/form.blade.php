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
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'nama_pemohon', 'name'=>'nama_pemohon', 'label'=>__('Nama Pemohon')])
                            </div>

                            <div class="col-md-6">
                                @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text',
                                'id'=>'tempat_sidang', 'name'=>'tempat_sidang', 'label'=>__('Tempat Sidang')])
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
                                Penggati')])
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

@endpush

@push('js')

@endpush
