@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
{{ $title }}
@endsection

@section('content')
@include('stisla.includes.breadcrumbs.breadcrumb-table')

<div class="section-body">

    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan kumpulan data ' . $title) }}.</p>

    <div class="row">
        <div class="col-12">

            {{-- gunakan jika ingin menampilkan sesuatu informasi --}}
            {{-- <div class="alert alert-info alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">{{ __('Informasi') }}</div>
                    This is a info alert.
                </div>
            </div> --}}

            {{-- gunakan jika mau ada filter --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-filter"></i> Filter Data</h4>
                    <div class="card-header-action">
                    </div>
                </div>
                <div class="card-body">

                    <form action="">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                @include('stisla.includes.forms.inputs.input', [
                                'type' => 'text',
                                'id' => 'filter_text',
                                'required' => false,
                                'label' => __('Pilih Text'),
                                'value' => request('filter_text'),
                                ])
                            </div>
                            <div class="col-md-3">
                                @include('stisla.includes.forms.inputs.input', [
                                'type' => 'date',
                                'id' => 'filter_date',
                                'required' => true,
                                'label' => __('Pilih Date'),
                                'value' => request('filter_date', date('Y-m-d')),
                                ])
                            </div>
                            <div class="col-md-3">
                                @include('stisla.includes.forms.selects.select2', [
                                'id' => 'filter_dropdown',
                                'name' => 'filter_dropdown',
                                'label' => __('Pilih Select2'),
                                'options' => $dropdownOptions ?? [],
                                'selected' => request('filter_dropdown'),
                                'with_all' => true,
                                ])
                            </div>
                        </div>
                        <button class="btn btn-primary icon"><i class="fa fa-search"></i> Cari Data</button>
                    </form>
                </div>
            </div> --}}

            @if ($data->count() > 0)
            @if ($canExport)
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
                    <div class="card-header-action">
                        @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => $routePdf])
                        @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => $routeExcel])
                        @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => $routeCsv])
                        @include('stisla.includes.forms.buttons.btn-print', ['link' => $routePrint])
                        @include('stisla.includes.forms.buttons.btn-json-download', ['link' => $routeJson])
                    </div>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-fas fa-hand-holding-heart"></i> {{ $title }}</h4>

                    <div class="card-header-action">
                        @if ($canImportExcel)
                        @include('stisla.includes.forms.buttons.btn-import-excel')
                        @endif

                        @if ($canCreate && !auth()->user()->hasRole('dukcapiltjt'))
                        @include('stisla.includes.forms.buttons.btn-add', ['link' => $routeCreate])
                        @endif
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        @if ($canExport)
                        <h6 class="text-primary">{!! __('Aksi Ekspor <small>(Client Side)</small>') !!}</h6>
                        @endif

                        <table class="table table-striped table-hovered" id="datatable" @if ($canExport)
                            data-export="true" data-title="{{ $title }}" @endif>
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">{{ __('Nama Pemohon') }}</th>
                                    <th class="text-center">{{ __('Jenis Permohonan') }}</th>
                                    <th class="text-center">{{ __('Nomor Perkara') }}</th>
                                    <th class="text-center">{{ __('Status Permohonan') }}</th>
                                    <th class="text-center">{{ __('Keterangan') }}</th>
                                    <th class="text-center">{{ __('Dokumen Penetapan') }}</th>
                                    <th class="text-center">{{ __('Nomor Telp') }}</th>
                                    <th class="text-center">{{ __('Alamat') }}</th>
                                    <th class="text-center">{{ __('Tempat Lahir') }}</th>
                                    <th class="text-center">{{ __('Tanggal lahir') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_pemohon }}</td>
                                    <td>{{ $item->jenisPermohonan->nama_jenis }}</td>
                                    <td>{{ $item->nomor_perkara }}</td>
                                    <td>{{ $item->status_permohonan }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->dokumen_penetapan }}</td>
                                    <td>{{ $item->nomor_telepon }}</td>
                                    <td>{{ $item->alamat_pemohon }}</td>
                                    <td>{{ $item->tempat_lahir }}</td>
                                    <td>{{ $item->tanggal_lahir }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $item->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @if ($canUpdate)
                                        @include('stisla.includes.forms.buttons.btn-edit', ['link' =>
                                        route('permohonanmasyarakats.edit', [$item->id])])
                                        @endif
                                        @if ($canDelete)
                                        @include('stisla.includes.forms.buttons.btn-delete', ['link' =>
                                        route('permohonanmasyarakats.destroy', [$item->id])])
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            @include('stisla.includes.others.empty-state', ['title' => 'Data ' . $title, 'icon' => '', 'link' =>
            $routeCreate])
            @endif
        </div>

    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

@push('scripts')
<script>

</script>
@endpush

@push('modals')
@if ($canImportExcel)
@include('stisla.includes.modals.modal-import-excel', ['formAction' => $routeImportExcel, 'downloadLink' =>
$excelExampleLink])
@endif

@foreach ($data as $item)
<!-- Modal Detail -->
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Permohonan Masyarakat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Nama Pemohon</th>
                                <td>{{ $item->nama_pemohon }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Permohonan</th>
                                <td>{{ $item->jenisPermohonan->nama_jenis }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Perkara</th>
                                <td>{{ $item->nomor_perkara }}</td>
                            </tr>
                            <tr>
                                <th>Status Permohonan</th>
                                <td>{{ $item->status_permohonan }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Dokumen Penetapan</th>
                                <td>{{ $item->dokumen_penetapan }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $item->nomor_telepon }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $item->alamat_pemohon }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>{{ $item->tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ date('d F Y', strtotime($item->tanggal_lahir)) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endpush