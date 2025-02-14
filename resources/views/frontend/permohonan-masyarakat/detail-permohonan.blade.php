@extends('frontend.layout.app')

@section('title', 'Detail Permohonan - PRIMADONA')

@section('content')
<!-- Page Banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Permohonan Masyarakat</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li>Permohonan Masyarakat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Permohonan Area -->
<div class="privacy-policy ptb-100">
    <div class="container">
        <div class="privacy-policy-text">
            <h2>Informasi Permohonan</h2>
            <table id="permohonanTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pemohon</th>
                        <th>Jenis Permohonan</th>
                        <th>Nomor Perkara</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permohonan as $item)
                    <tr>
                        <td>{{ $item->nama_pemohon }}</td>
                        <td>{{ $item->jenisPermohonan->nama_jenis ?? 'N/A' }}</td>
                        <td>{{ $item->nomor_perkara }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm"
                                onclick="showDetail({{ json_encode($item) }})">
                                <i class="las la-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">
                    Detail Permohonan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4">Informasi Pemohon</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Nama Pemohon</label>
                                    <div id="modal-nama" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Jenis Permohonan</label>
                                    <div id="modal-jenis" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Nomor Perkara</label>
                                    <div id="modal-nomor" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Status Permohonan</label>
                                    <div id="modal-status" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Keterangan</label>
                                    <div id="modal-keterangan" class="form-control-plaintext border-bottom"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Nomor Telepon</label>
                                    <div id="modal-telepon" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Alamat</label>
                                    <div id="modal-alamat" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Tempat Lahir</label>
                                    <div id="modal-tempat-lahir" class="form-control-plaintext border-bottom"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted mb-2">Tanggal Lahir</label>
                                    <div id="modal-tanggal-lahir" class="form-control-plaintext border-bottom"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="las la-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('assets/template/css/jquery.dataTables.min.css') }}">
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="{{ asset('assets/template/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    // Pastikan document ready
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#permohonanTable').DataTable({
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

        // Event handler untuk tombol close modal
        $('.btn-close, .btn-secondary').on('click', function() {
            $('#detailModal').modal('hide');
        });
    });

    // Definisikan fungsi showDetail di scope global
    window.showDetail = function(item) {
        // Parse item jika diterima sebagai string JSON
        if (typeof item === 'string') {
            item = JSON.parse(item);
        }

        // Update konten modal
        $('#modal-nama').text(item.nama_pemohon || '-');
        $('#modal-jenis').text(item.jenis_permohonan ? item.jenis_permohonan.nama_jenis : '-');
        $('#modal-nomor').text(item.nomor_perkara || '-');
        $('#modal-status').text(item.status_permohonan || '-');
        $('#modal-keterangan').text(item.keterangan || '-');
        $('#modal-telepon').text(item.nomor_telepon || '-');
        $('#modal-alamat').text(item.alamat_pemohon || '-');
        $('#modal-tempat-lahir').text(item.tempat_lahir || '-');
        $('#modal-tanggal-lahir').text(item.tanggal_lahir || '-');

        // Tampilkan modal
        $('#detailModal').modal('show');
    };
</script>
@endpush
