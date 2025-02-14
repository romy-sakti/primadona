@extends('frontend.layout.app')

@section('title', 'Biaya Permohonan - PRIMADONA')

@section('content')
<!-- Page Banner Area -->
<div class="page-banner bg-1">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-content">
                    <h2>Biaya Permohonan</h2>
                    <ul>
                        <li><a href="{{ route('portal') }}">Beranda <i class="las la-angle-right"></i></a></li>
                        <li>Biaya Permohonan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Banner Area -->

<!-- Biaya Area -->
<div class="privacy-policy ptb-100">
    <div class="container">
        <div class="privacy-policy-text">
            <h2>Rincian Biaya Permohonan</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th width="50%">Jenis Biaya</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Biaya Pendaftaran</th>
                            <td>Rp {{ number_format($biaya->biaya_pendaftaran ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Biaya ATK & Administrasi</th>
                            <td>Rp {{ number_format($biaya->biaya_atk_administrasi ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>PNBP Panggilan</th>
                            <td>Rp {{ number_format($biaya->pnbp_panggilan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Materai</th>
                            <td>Rp {{ number_format($biaya->materai ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Redaksi</th>
                            <td>Rp {{ number_format($biaya->redaksi ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-primary">
                            <th>Total Biaya</th>
                            <td><strong>Rp {{ number_format(
                                    ($biaya->biaya_pendaftaran ?? 0) +
                                    ($biaya->biaya_atk_administrasi ?? 0) +
                                    ($biaya->pnbp_panggilan ?? 0) +
                                    ($biaya->materai ?? 0) +
                                    ($biaya->redaksi ?? 0),
                                    0, ',', '.'
                                    ) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Biaya Area -->
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
