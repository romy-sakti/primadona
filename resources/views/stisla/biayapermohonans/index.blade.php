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
                    <h4><i class="fas fa-coins"></i> {{ $title }}</h4>

                    <div class="card-header-action">
                        @if ($canImportExcel)
                        @include('stisla.includes.forms.buttons.btn-import-excel')
                        @endif

                        @if ($canCreate)
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
                                    <th class="text-center">{{ __('Biaya Pendaftaran') }}</th>
                                    <th class="text-center">{{ __('Biaya ATK / Administrasi') }}</th>
                                    <th class="text-center">{{ __('PNBP Panggilan') }}</th>
                                    <th class="text-center">{{ __('Materai') }}</th>
                                    <th class="text-center">{{ __('Redaksi') }}</th>
                                    <th class="text-center">{{ __('Total') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                @php
                                $totalPerBaris = $item->biaya_pendaftaran + $item->biaya_atk_administrasi +
                                $item->pnbp_panggilan + $item->materai + $item->redaksi;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Rp{{ number_format($item->biaya_pendaftaran, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->biaya_atk_administrasi, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->pnbp_panggilan, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->materai, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->redaksi, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($totalPerBaris, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="showDetail(
                                            '{{ $item->biaya_pendaftaran }}',
                                            '{{ $item->biaya_atk_administrasi }}',
                                            '{{ $item->pnbp_panggilan }}',
                                            '{{ $item->materai }}',
                                            '{{ $item->redaksi }}',
                                            '{{ $totalPerBaris }}'
                                        )">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($canUpdate)
                                        @include('stisla.includes.forms.buttons.btn-edit', ['link' =>
                                        route('biayapermohonans.edit', [$item->id])])
                                        @endif
                                        @if ($canDelete)
                                        @include('stisla.includes.forms.buttons.btn-delete', ['link' =>
                                        route('biayapermohonans.destroy', [$item->id])])
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
    function showDetail(biayaPendaftaran, biayaAtk, pnbpPanggilan, materai, redaksi, total) {
    // Format angka ke format Rupiah
    const formatRupiah = (angka) => {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(angka);
    };

    // Set nilai ke dalam modal
    document.getElementById('detail-biaya-pendaftaran').textContent = formatRupiah(biayaPendaftaran);
    document.getElementById('detail-biaya-atk').textContent = formatRupiah(biayaAtk);
    document.getElementById('detail-pnbp').textContent = formatRupiah(pnbpPanggilan);
    document.getElementById('detail-materai').textContent = formatRupiah(materai);
    document.getElementById('detail-redaksi').textContent = formatRupiah(redaksi);
    document.getElementById('detail-total').textContent = formatRupiah(total);

    // Tampilkan modal
    $('#detailModal').modal('show');
}
</script>
@endpush

@push('modals')
@if ($canImportExcel)
@include('stisla.includes.modals.modal-import-excel', ['formAction' => $routeImportExcel, 'downloadLink' =>
$excelExampleLink])
@endif

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Biaya Permohonan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="250">Biaya Pendaftaran</th>
                            <td id="detail-biaya-pendaftaran"></td>
                        </tr>
                        <tr>
                            <th>Biaya ATK / Administrasi</th>
                            <td id="detail-biaya-atk"></td>
                        </tr>
                        <tr>
                            <th>PNBP Panggilan</th>
                            <td id="detail-pnbp"></td>
                        </tr>
                        <tr>
                            <th>Materai</th>
                            <td id="detail-materai"></td>
                        </tr>
                        <tr>
                            <th>Redaksi</th>
                            <td id="detail-redaksi"></td>
                        </tr>
                        <tr class="bg-light">
                            <th>Total</th>
                            <td id="detail-total" class="font-weight-bold"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endpush