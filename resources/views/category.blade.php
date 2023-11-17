<div>
    @push('style')
    @endpush

    @include('layouts.header')

    <div class="page-title-overlap bg-primary pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('welcome') }}">
                                <i class="czi-home"></i>Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">
                            {{ $title }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 text-light mb-0">{{ $title }}</h1>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Content  -->
            <section class="col-lg-12">
                <!-- Toolbar-->
                <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
                    <div class="d-flex flex-wrap">
                        <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                            <form method="GET" action="{{ Request::fullUrl() }}" class="form-inline flex-nowrap mr-3 mr-sm-4 pb-3">
                                @csrf
                                {{-- <label class="text-light opacity-75 text-nowrap mr-2 d-none d-sm-block" for="sorting">
                                    Trier par:
                                </label>
                                <select name="trier" class="form-control custom-select" id="sorting" onChange="this.form.submit()">
                                    @foreach (specific_article($articles, 18) as $article)
                                        <option value="{{ $item->id }}" {{ ($item->id == request('trier')) ? 'selected' : '' }} >
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                <span class="font-size-sm text-light opacity-75 text-nowrap ml-2 d-none d-md-block">
                                    {{ count($rubric->products) }} produits
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
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
            </section>
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
</div>
