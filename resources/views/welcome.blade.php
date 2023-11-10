<div>
    @push('style')
    @endpush
    @include('layouts.header')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tns-carousel tns-nav-enabled tns-nav-inside">
                        <div class="tns-carousel-inner data-carousel-options='{mode: carousel, speed: 1000, autoplayTimeout: 5000, autoplay: true}'">
                            @foreach (specific_article($articles, 18) as $article)
                                @if($article->getMedia('image')->first())
                                    <a href="{{ $article->link ? url($article->link) : '#' }}">
                                        <img src="{{ $article->getMedia('image')->first()->getUrl() }}" alt="{{ setting()->title }}">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5" style="background-color: #e2b900;">
        <div class="container">
            <div class="row pb-3">
                @foreach (specific_article($articles, 267) as $article)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="d-flex">
                            <i class="{{ $article->icon }} text-primary" style="font-size: 2.25rem;"></i>
                            <div class="ps-3">
                                <h2 class="fs-base text-light mb-1">
                                    {{ $article->title }}
                                </h2>
                                <p class="mb-0 fs-ms text-light opacity-50">
                                    {{ $article->subtitle }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container position-relative pt-3 pt-lg-0 pb-5" style="z-index: 10;">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-body px-3 pt-grid-gutter pb-0">
                        <div class="row g-0 ps-1">
                            @foreach (specific_article($articles, 125)->where('active_size', 1)->take(4) as $article)
                                @if($article->getMedia('image')->first())
                                    <div class="col-md-3 px-2 mb-grid-gutter">
                                        <a class="d-block text-center text-decoration-none me-1" href="{{ route('article.show', $article->slug) }}">
                                            <div class="box-img">
                                                <img class="d-block rounded mb-3" src="{{ $article->getMedia('image')->first()->getUrl('thumb') }}" alt="{{ $article->title }}">
                                            </div>
                                            <h3 class="fs-base pt-1 mb-0">
                                                {{ $article->title }}
                                            </h3>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>




    @push('script')
    @endpush
</div>
