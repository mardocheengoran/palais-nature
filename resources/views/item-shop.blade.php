 <!-- Product-->
 <div class="mt-5 {{ (isset($column)) ? $column : '' }}">
    <div class="card product-card">
        @if ($article->price_old)
            <span class="badge bg-primary badge-shadow">
                -{{ number_format(100-($article->price_new*100)/$article->price_old, 1, ',', ' ') }}%
            </span>
        @endif
        <a class="overflow-hidden card-img-top d-block" href="{{ route('article.show', $article->slug) }}">
            @if($article->getMedia('image')->first())
                {{-- <img src="{{ $article->getMedia('image')->first()->getUrl($thumb) }}" alt="{{ $article->title }}"> --}}
                <img src="{{ $article->getMedia('image')->first()->getUrl() }}" alt="{{ $article->title }}">
            @endif
        </a>
        <div class="py-2 card-body">
            {{-- <a class="pb-1 product-meta d-block fs-xs" href="#">Fruits and Vegetables</a> --}}
            <h3 class="product-title fs-sm text-truncate">
                <a href="{{ route('article.show', $article->slug) }}">
                    {{ $article->title }}
                </a>
            </h3>
            <div class="product-price">
                <span class="text-accent">{{ devise($article->price_new) }}</span>
                @if ($article->price_old)
                    <del class="fs-sm text-muted">{{ devise($article->price_old) }}</del>
                @endif
            </div>
        </div>
        {{-- <div class="product-floating-btn">
            <a href="{{ route('article.show', $article->slug) }}" class="btn btn-primary btn-sm">
                +<i class="ci-cart fs-base ms-1"></i>
            </a>
        </div> --}}
        <div class="card-body card-body-hidden">
            <a href="{{ route('article.show', $article->slug) }}" class="mb-2 btn btn-primary btn-sm d-block w-100">
                <i class="ci-cart fs-sm me-1"></i> Découvrez
            </a>
            {{-- <div class="text-center">
                <a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal">
                    <i class="align-middle ci-eye me-1"></i>Quick view
                </a>
            </div> --}}
        </div>
    </div>
    <hr class="d-sm-none">
</div>
