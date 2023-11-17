 <!-- Product-->
 <div class="mt-5 {{ (isset($column)) ? $column : '' }}">
    <div class="card product-card">
        @if ($article->price_old)
            <span class="badge bg-primary badge-shadow">
                -{{ number_format(100-($article->price_new*100)/$article->price_old, 1, ',', ' ') }}%
            </span>
        @endif
        <a class="card-img-top d-block overflow-hidden" href="{{ route('article.show', $article->slug) }}">
            @if($article->getMedia('image')->first())
                <img src="{{ $article->getMedia('image')->first()->getUrl($thumb) }}" alt="{{ $article->title }}">
            @endif
        </a>
        <div class="card-body py-2">
            {{-- <a class="product-meta d-block fs-xs pb-1" href="#">Fruits and Vegetables</a> --}}
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
            <button class="btn btn-primary btn-sm d-block w-100 mb-2" type="button">
                <i class="ci-cart fs-sm me-1"></i> Découvrez
            </button>
            {{-- <div class="text-center">
                <a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal">
                    <i class="ci-eye align-middle me-1"></i>Quick view
                </a>
            </div> --}}
        </div>
    </div>
    <hr class="d-sm-none">
</div>
