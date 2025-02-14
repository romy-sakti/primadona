<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/bootstrap.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/animate.min.css') }}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/meanmenu.min.css') }}">
    <!-- Line Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/line-awesome.min.css') }}">
    <!-- Magnific CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/magnific-popup.css') }}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/owl.carousel.min.css') }}">
    <!-- Owl Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/owl.theme.default.min.css') }}">
    <!-- Odometer CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/odometer.css') }}">
    <!-- Stylesheet CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/style.css') }}">
    <!-- Stylesheet Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/responsive.css') }}">
    <!-- Theme Dark CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template/css/theme-dark.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/template/img/favicon.png') }}">
    <!-- Title -->
    <title>Atorn - Law Firm & Attorney Website HTML Template</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>
    <!-- Preloader Area -->
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="lds-hourglass"></div>
            </div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Header Area -->
    <header class="header-area">
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-sm-6">
                        <ul class="left-info">
                            <li>
                                <a href="mailto:hello@atorn.com">
                                    <i class="las la-envelope"></i>
                                    hello@atorn.com
                                </a>
                            </li>
                            <li>
                                <a href="tel:+823-456-879">
                                    <i class="las la-phone"></i>
                                    +0123 456 789
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <ul class="right-info">
                            <li>
                                <a href="https://www.facebook.com/login/" target="_blank">
                                    <i class="lab la-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/i/flow/login" target="_blank">
                                    <i class="lab la-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/" target="_blank">
                                    <i class="lab la-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.google.co.uk/" target="_blank">
                                    <i class="lab la-google-plus"></i>
                                </a>
                            </li>

                            <li class="heder-btn">
                                <a href="javascript:void(0)">Masuk</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="atorn-responsive-nav">
                <div class="container">
                    <div class="atorn-responsive-menu">
                        <div class="logo">
                            <a href="index.html">
                                <img src="{{ asset('assets/images/logo.png') }}" class="logo1" alt="logo">
                                <img src="{{ asset('assets/images/logo-white.png') }}" class="logo2" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="atorn-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="index.html">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo1" alt="logo">
                            <img src="{{ asset('assets/images/logo-white.png') }}" class="logo2" alt="logo">
                        </a>

                        {{-- <div class="collapse navbar-collapse mean-menu">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Login </a>

                                </li>
                            </ul>
                        </div> --}}
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Navbar Area -->
    </header>
    <!-- End Header Area -->

    <!-- Search Overlay -->
    <div class="search-overlay">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>

                <div class="search-overlay-close">
                    <span class="search-overlay-close-line"></span>
                    <span class="search-overlay-close-line"></span>
                </div>

                <div class="search-overlay-form">
                    <form>
                        <input type="text" class="input-search" placeholder="Search here...">
                        <button type="submit"><i class='las la-search'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Search Overlay -->

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
                                @if($item->file_peraturan)
                                <a href="{{ $item->file_url }}" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="las la-file-pdf"></i> PDF
                                </a>
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

    <!-- Footer bottom Area -->
    <div class="footer-bottom">
        <div class="container d-flex justify-content-between">
            <p class="mb-0">&copy; {{ date('Y') }} PRIMADONA</p>
            <p class="mb-0">Pengadilan Negeri Tanjung Jabung Timur</p>
        </div>
    </div>
    <!-- End Footer bottom Area -->

    <!-- Go Top -->
    <div class="go-top">
        <i class="las la-hand-point-up"></i>
    </div>
    <!-- End Go Top -->

    <!-- jQuery first, then Bootstrap JS -->
    <script src="{{ asset('assets/template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Meanmenu JS -->
    <script src="{{ asset('assets/template/js/meanmenu.min.js') }}"></script>
    <!-- Magnific JS -->
    <script src="{{ asset('assets/template/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('assets/template/js/owl.carousel.min.js') }}"></script>
    <!-- Odometer JS -->
    <script src="{{ asset('assets/template/js/odometer.min.js') }}"></script>
    <!-- Appear JS -->
    <script src="{{ asset('assets/template/js/jquery.appear.js') }}"></script>
    <!-- Form Validator JS -->
    <script src="{{ asset('assets/template/js/form-validator.min.js') }}"></script>
    <!-- Contact JS -->
    <script src="{{ asset('assets/template/js/contact-form-script.js') }}"></script>
    <!-- Ajaxchimp JS -->
    <script src="{{ asset('assets/template/js/jquery.ajaxchimp.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/template/js/custom.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
</body>

</html>
