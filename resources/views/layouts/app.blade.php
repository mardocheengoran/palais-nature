<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <meta name="google-site-verification" content="NesQxZSeTnbcsapjdRET1bYmpnbh4oD4ZOWY-uwODp8" /> --}}
        <meta name="google-site-verification" content="GjJN_Q89-eiZ_hSFw9bjR_mF9QGanYRn8XCwFuP1Saw" />

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WNDS79N');</script>
        <!-- End Google Tag Manager -->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-9QW52S0934"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-9QW52S0934');
        </script>

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
        <!-- Animate.css -->
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"> --}}

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Montserrat:wght@400;500&family=Nunito+Sans&display=swap" rel="stylesheet">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> --}}
        <!-- Animation CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
        <!-- Latest Bootstrap min CSS -->
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <!-- Icon Font CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
        <!--- owl carousel CSS-->
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.default.min.css') }}">
        <!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <!-- Slick CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
        <!-- Style CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css').'?t='.time() }}">


        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <!-- Styles -->
        @livewireStyles

        <link rel="stylesheet" href="{{ asset('css/shop.css').'?t='.time() }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css').'?t='.time() }}">
    </head>
    <body>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WNDS79N"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        {{-- @include('layouts.admin-bar') --}}

        @include('layouts.load')
        @yield('content')
        @include('layouts.footer')

        {{-- <!-- Page JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
        <!-- Purpose JS -->
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
        <script src="https://preview.webpixels.io/purpose-website-ui-kit/assets/libs/isotope-layout/dist/isotope.pkgd.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script> --}}

        <!-- Latest jQuery -->
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <!-- popper min js -->
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <!-- Latest compiled and minified Bootstrap -->
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- owl-carousel min js  -->
        <script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js') }}"></script>
        <!-- magnific-popup min js  -->
        <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
        <!-- waypoints min js  -->
        <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
        <!-- parallax js  -->
        <script src="{{ asset('assets/js/parallax.js') }}"></script>
        <!-- countdown js  -->
        <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
        <!-- imagesloaded js -->
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <!-- isotope min js -->
        <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
        <!-- jquery.dd.min js -->
        <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
        <!-- slick js -->
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <!-- elevatezoom js -->
        <script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script>
        <!-- scripts js -->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>

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

        <!-- Messenger Plugin de discussion Code -->
        <div id="fb-root"></div>

        <!-- Your Plugin de discussion code -->
        <div id="fb-customer-chat" class="fb-customerchat">
        </div>

        <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "103799478732611");
        chatbox.setAttribute("attribution", "biz_inbox");
        </script>

        <!-- Your SDK code -->
        <script>
        window.fbAsyncInit = function() {
            FB.init({
            xfbml            : true,
            version          : 'v17.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/fr_FR/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>

        @stack('script')
    </body>
</html>
