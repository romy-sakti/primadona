<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PRIMADONA') - PN Tanjung Jabung Timur</title>

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
    <link rel="icon" type="image/png" href="{{ asset('assets/template/img/favicon.png') }}">
    @stack('styles')
</head>

<body>
    <!-- Header content dari header.blade.php -->
    @include('frontend.layout.header')

    <!-- Content -->
    @yield('content')

    <!-- Footer content dari footer.blade.php -->
    @include('frontend.layout.footer')

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

    @stack('scripts')
</body>

</html>
