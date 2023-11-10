<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Référencement --}}
        {{-- <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ (isset($meta->icon)) ? $meta->icon : ''  }}">
        <meta name="theme-color" content="#ffffff">
        <meta name="description" content="{{ (isset($meta->description)) ? $meta->description : '' }}">
        <meta property="og:locale" content="{{ app()->getLocale() }}">
        <meta property="og:type" content="{{ (isset($meta->type)) ? $meta->type : '' }}">
        <meta property="og:title" content="{{ (isset($parametre->libelle)) ? $parametre->libelle : '' }} {{ $title }}">
        <meta property="og:description" content="{{ (isset($meta->description)) ? $meta->description : '' }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ (isset($parametre->libelle)) ? $parametre->libelle : '' }}">
        <meta property="article:publisher" content="https://www.facebook.com/iwariapic/">
        <meta property="og:image" content="{{ (isset($meta->image)) ? $meta->image : '' }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ (isset($meta->libelle)) ? $meta->libelle : '' }}">
        <meta name="twitter:description" content="{{ (isset($meta->description)) ? $meta->description : '' }}">
        <meta name="twitter:image" content="{{ (isset($meta->image)) ? $meta->image : '' }}"> --}}

        <title>
            {{ config('app.name', 'Laravel') }}
            @isset($title)
                - {{ $title }}
            @endisset
        </title>

        @stack('style')

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.2/css/boxicons.min.css">

        <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/png">
        <!-- Font Awesome 5 -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
        <!-- cdn icofont -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/icofont@1.0.1-alpha.1/icofont.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/icofont/icofont.css">
        <!-- Flatpickr -->
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" /> --}}
        <!-- fancybox.css -->
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"> --}}

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Montserrat:wght@400;500&family=Nunito+Sans&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Montserrat:wght@500;900&family=Nunito+Sans:opsz,wght@6..12,400;6..12,500&family=Outfit:wght@100;200;300;400;500&display=swap" rel="stylesheet">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> --}}
        <!-- Animation CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

        <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
        <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css"/>
        <link rel="stylesheet" media="screen" href="vendor/tiny-slider/dist/tiny-slider.css"/>
        <link rel="stylesheet" media="screen" href="vendor/drift-zoom/dist/drift-basic.min.css"/>
        <!-- Main Theme Styles + Bootstrap-->
        <link rel="stylesheet" media="screen" href="css/theme.min.css">

        <link rel="stylesheet" href="{{ asset('css/style.css').'?t='.time() }}">


        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <!-- Styles -->
        @livewireStyles

        <link rel="stylesheet" href="{{ asset('css/shop.css').'?t='.time() }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css').'?t='.time() }}">
    </head>
    <body class="handheld-toolbar-enabled">

        @yield('content')
        @include('layouts.footer')

        {{-- <!-- Page JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
        <!-- Purpose JS -->
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
        <script src="https://preview.webpixels.io/purpose-website-ui-kit/assets/libs/isotope-layout/dist/isotope.pkgd.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script> --}}

        <!-- Toolbar for handheld devices (Default)-->
        <div class="handheld-toolbar">
            <div class="d-table table-layout-fixed w-100">
                <a class="d-table-cell handheld-toolbar-item" href="account-wishlist.html">
                    <span class="handheld-toolbar-icon"><i class="ci-heart"></i></span>
                    <span class="handheld-toolbar-label">Wishlist</span>
                </a>
                <a class="d-table-cell handheld-toolbar-item" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" onclick="window.scrollTo(0, 0)">
                    <span class="handheld-toolbar-icon"><i class="ci-menu"></i></span>
                    <span class="handheld-toolbar-label">Menu</span>
                </a>
                <a class="d-table-cell handheld-toolbar-item" href="shop-cart.html">
                    <span class="handheld-toolbar-icon"><i class="ci-cart"></i>
                        <span class="badge bg-primary rounded-pill ms-1">4</span>
                    </span>
                    <span class="handheld-toolbar-label">$265.00</span>
                </a>
            </div>
        </div>
        <!-- Back To Top Button-->
        <a class="btn-scroll-top" href="#top" data-scroll>
            <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span>
            <i class="btn-scroll-top-icon ci-arrow-up"></i>
        </a>
        <!-- Vendor scrits: js libraries and plugins-->
        <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/simplebar/dist/simplebar.min.js"></script>
        <script src="vendor/tiny-slider/dist/min/tiny-slider.js"></script>
        <script src="vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
        <script src="vendor/drift-zoom/dist/Drift.min.js"></script>
        <!-- Main theme script-->
        <script src="js/theme.min.js"></script>



        <script>
            /* var owl = $(".owl-carousel");
            owl.owlCarousel({
                //items: 4,
                // items change number for slider display on desktop
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                nav:true,
                responsive:{
                    0:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            }); */
        </script>

        @livewireScripts
        @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />

        @stack('script')
    </body>
</html>
