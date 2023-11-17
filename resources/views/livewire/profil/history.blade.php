<div>
    @include('layouts.header')
    <!-- Page Title-->
    <div class="page-title-overlap bg-primary pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('welcome') }}"><i class="ci-home"></i>Accueil</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap"><a href="{{ route('profil.index') }}">Compte</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">{{ $title }}</h1>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-3">
        <div class="row">
            @include('livewire.profil.account')
            <!-- Content  -->
            <div class="mt-5 col-lg-9 order-lg-1 order-0">
                <div class="infinite-scroll">
                    <div class="row">
                        @foreach ($products as $article)
                            @include('item-shop', [
                                'articles' => $article,
                                'column' => 'col-md-3 col-6',
                                'thumb' => 'thumb',
                            ])
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="m-auto text-center"><img class="text-center w-25" src="/img/loading.gif" alt="Chargement..." /></div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
@endpush
