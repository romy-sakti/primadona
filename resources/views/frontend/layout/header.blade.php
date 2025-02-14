<body>
    <!-- Preloder Area -->
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="lds-hourglass"></div>
            </div>
        </div>
    </div>
    <!-- End Preloder Area -->

    <!-- Heder Area -->
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
                            <a href="{{ route('portal') }}">
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
                        <a class="navbar-brand" href="{{ route('portal') }}">
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
    <!-- End Heder Area -->

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
