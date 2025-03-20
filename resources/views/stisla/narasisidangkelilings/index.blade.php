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
                    <h4><i class="fa fa-car"></i> {{ $title }}</h4>

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
                                    <th class="text-center">{{ __('Tahun') }}</th>
                                    <th class="text-center">{{ __('Narasi') }}</th>
                                    <th class="text-center">{{ __('Foto') }}</th>
                                    <th class="text-center">{{ __('Dokumen') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->narasi }}</td>
                                    <td class="text-center">
                                        @php
                                        $fotos = is_string($item->foto) ? json_decode($item->foto ?? '[]') :
                                        $item->foto;
                                        @endphp
                                        @if($fotos && count($fotos) > 0)
                                        @foreach($fotos as $foto)
                                        <img src="{{ asset('storage/narasisidangkeliling/foto/' . $foto) }}" alt="Foto"
                                            class="img-thumbnail" style="height: 80px; cursor: pointer"
                                            onclick="showImage('{{ asset('storage/narasisidangkeliling/foto/' . $foto) }}')">
                                        @endforeach
                                        @else
                                        <span class="badge badge-warning">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                        $dokumens = is_string($item->dokumen) ? json_decode($item->dokumen ?? '[]') :
                                        $item->dokumen;
                                        @endphp
                                        @if($dokumens && count($dokumens) > 0)
                                        @foreach($dokumens as $dokumen)
                                        <a href="{{ asset('storage/narasisidangkeliling/dokumen/' . $dokumen) }}"
                                            target="_blank" class="btn btn-info btn-sm mb-1">
                                            <i class="fas fa-file"></i> Lihat Dokumen
                                        </a><br>
                                        @endforeach
                                        @else
                                        <span class="badge badge-warning">Tidak ada dokumen</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="showDetail(
                                                '{{ $item->id }}',
                                                '{{ $item->tahun }}',
                                                '{{ $item->narasi }}',
                                                '{{ json_encode($item->foto) }}',
                                                '{{ json_encode($item->dokumen) }}'
                                            )">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($canUpdate)
                                        @include('stisla.includes.forms.buttons.btn-edit', ['link' =>
                                        route('narasisidangkelilings.edit', [$item->id])])
                                        @endif
                                        @if ($canDelete)
                                        @include('stisla.includes.forms.buttons.btn-delete', ['link' =>
                                        route('narasisidangkelilings.destroy', [$item->id])])
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
<style>
    .modal-preview-image {
        max-width: 100%;
        height: auto;
    }

    .modal-xl {
        max-width: 90%;
    }

    .dokumen-iframe {
        width: 100%;
        height: 500px;
        border: none;
    }

    .nav-tabs .nav-link {
        padding: 0.5rem 1rem;
        margin-right: 5px;
    }
</style>
@endpush

@push('js')
@endpush

@push('scripts')
<script>
    function showImage(imageUrl) {
    $('#previewImage').attr('src', imageUrl);
    $('#imagePreviewModal').modal('show');
}

function showDetail(id, tahun, narasi, fotos, dokumens) {
    // Parse string JSON menjadi array jika belum berbentuk array
    try {
        fotos = typeof fotos === 'string' ? JSON.parse(fotos || '[]') : fotos;
        dokumens = typeof dokumens === 'string' ? JSON.parse(dokumens || '[]') : dokumens;
    } catch (e) {
        console.error('Error parsing JSON:', e);
        fotos = [];
        dokumens = [];
    }

    // Set data ke modal
    $('#detail-tahun').text(tahun || '-');
    $('#detail-narasi').text(narasi || '-');

    // Tampilkan foto
    let fotoContainer = $('#detail-foto');
    fotoContainer.empty();

    if (Array.isArray(fotos) && fotos.length > 0) {
        fotos.forEach(foto => {
            fotoContainer.append(`
                <div class="col-md-4 mb-3">
                    <img src="${assetUrl}/storage/narasisidangkeliling/foto/${foto}"
                         class="img-thumbnail"
                         style="height: 150px; cursor: pointer"
                         onclick="showImage('${assetUrl}/storage/narasisidangkeliling/foto/${foto}')">
                </div>
            `);
        });
    } else {
        fotoContainer.append(`
            <div class="col-12">
                <div class="alert alert-light">
                    <i class="fas fa-info-circle"></i> Tidak ada foto yang tersedia
                </div>
            </div>
        `);
    }

    // Tampilkan dokumen dalam tabs
    let dokumenTab = $('#dokumen-tab');
    let dokumenContent = $('#dokumen-content');
    dokumenTab.empty();
    dokumenContent.empty();

    if (dokumens === null) {
        dokumenTab.hide();
        dokumenContent.append(`
            <div class="alert alert-light">
                <i class="fas fa-info-circle"></i> Tidak ada dokumen yang tersedia
            </div>
        `);
    } else if (Array.isArray(dokumens) && dokumens.length > 0) {
        dokumenTab.show();
        dokumens.forEach((dokumen, index) => {
            // Tambah tab
            dokumenTab.append(`
                <a class="nav-link ${index === 0 ? 'active' : ''}"
                   id="doc-tab-${index}"
                   data-toggle="tab"
                   href="#doc-content-${index}"
                   role="tab">
                    <i class="fas fa-file"></i> Dokumen ${index + 1}
                </a>
            `);

            // Tambah konten
            dokumenContent.append(`
                <div class="tab-pane fade ${index === 0 ? 'show active' : ''}"
                     id="doc-content-${index}"
                     role="tabpanel">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="dokumen-iframe"
                                src="${assetUrl}/storage/narasisidangkeliling/dokumen/${dokumen}">
                        </iframe>
                    </div>
                    <div class="mt-2">
                        <a href="${assetUrl}/storage/narasisidangkeliling/dokumen/${dokumen}"
                           target="_blank"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                        </a>
                    </div>
                </div>
            `);
        });
    } else {
        dokumenTab.hide();
        dokumenContent.append(`
            <div class="alert alert-light">
                <i class="fas fa-info-circle"></i> Tidak ada dokumen yang tersedia
            </div>
        `);
    }

    // Tampilkan modal
    $('#detailModal').modal('show');
}

// Tambahkan variable assetUrl untuk base URL
const assetUrl = "{{ asset('') }}";
</script>
@endpush

@push('modals')
@if ($canImportExcel)
@include('stisla.includes.modals.modal-import-excel', ['formAction' => $routeImportExcel, 'downloadLink' =>
$excelExampleLink])
@endif

<!-- Modal Preview Image -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Preview Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="modal-preview-image">
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Narasi Sidang Keliling</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tahun</label>
                            <p id="detail-tahun" class="font-weight-bold"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Narasi</label>
                            <p id="detail-narasi" class="font-weight-bold"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Foto</label>
                            <div id="detail-foto" class="row">
                                <!-- Foto akan ditampilkan di sini -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dokumen</label>
                            <div class="nav nav-tabs" id="dokumen-tab" role="tablist">
                                <!-- Tab dokumen akan ditampilkan di sini -->
                            </div>
                            <div class="tab-content mt-3" id="dokumen-content">
                                <!-- Konten dokumen akan ditampilkan di sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endpush