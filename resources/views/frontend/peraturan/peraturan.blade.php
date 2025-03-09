@extends('frontend.layout.app')

@section('title', 'Peraturan - PRIMADONA')

@section('content')
<!-- Page Banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Peraturan</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li>Peraturan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Banner Area -->

<!-- Peraturan Area -->
<div class="privacy-policy ptb-100">
    <div class="container">
        <div class="privacy-policy-text">
            <h2>Daftar Peraturan</h2>
            <table id="peraturanTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Nomor Peraturan</th>
                        <th>Tahun</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peraturan as $item)
                    <tr>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->nomor_peraturan }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-center">
                            @if($item->file_peraturan && Storage::exists($item->file_peraturan))
                                <a href="{{ $item->file_url }}" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="las la-file-pdf"></i> PDF
                                </a>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="las la-file-alt"></i> Dokumen tidak tersedia
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Peraturan Area -->
@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('assets/template/css/jquery.dataTables.min.css') }}">
<style>
    .modal-dialog {
        max-width: 60%;
    }
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
    .form-control-plaintext {
        padding: 0.5rem 0;
        font-weight: 500;
        color: #333;
    }
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="{{ asset('assets/template/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#peraturanTable').DataTable({
            "responsive": true,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush
