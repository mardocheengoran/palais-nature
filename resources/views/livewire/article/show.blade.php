<x-slot name="title">{{ $article->title }}</x-slot>
<div>
    @include('composant.header.header-1')
    @include($article->rubric->component_detail, [
        'article' => $article,
    ])

    @include('composant.footer.footer-ecommerce')
    @push('script')
        {{-- <script>
            const myCarouselElement = document.querySelector('#carouselExampleControls')
                const carousel = new bootstrap.Carousel(myCarouselElement, {
                interval: 2000000,
                wrap: false
            });
        </script> --}}

        <script>
            var owl = $(".owl-carousel");
            owl.owlCarousel({
                //items: 4,
                // items change number for slider display on desktop
                loop: false,
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
            });
        </script>
    @endpush
</div>
