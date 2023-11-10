<div class="item {{ (isset($column)) ? $column : '' }}">
    <div class="product_wrap">
        {{-- {{ new_price($article->id) }} --}}
        @if ($flash = new_price($article->id))
            <span class="pr_flash">
                -{{ number_format($flash->price_discount, 1, ',', ' ') }}%
            </span>
        @else
            @if ($article->price_old)
                <span class="pr_flash">
                    -{{ number_format(100-($article->price_new*100)/$article->price_old, 1, ',', ' ') }}%
                </span>
            @endif
        @endif
        <a href="{{ route('article.show', $article->slug) }}">
        <div class="product_img">
            @if(!empty($article->getMedia('image')->first()))
                <div class="me-1 d-inline-block">
                    <img src="{{ url($article->getMedia('image')->first()->getUrl($thumb)) }}" alt="{{ $article->title }}">
                </div>
            @endif
            @if(!empty($article->getMedia('image')[1]))
                <div class="me-1 d-inline-block">
                    <img class="product_hover_img" src="{{ url($article->getMedia('image')[1]->getUrl($thumb)) }}" alt="{{ $article->title }}">
                </div>
            @endif

            {{-- <div class="product_action_box">
                <ul class="list_none pr_action_btn">
                    <li class="add-to-cart">
                        <a href="{{ route('article.show', $article->slug) }}">
                            <i class="icon-basket-loaded"></i> Ajouter au panier
                        </a>
                    </li> --}}
                    {{-- <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                    <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                    <li><a href="#"><i class="icon-heart"></i></a></li> --}}
                {{-- </ul>
            </div> --}}
            </div>
        </a>
        <div class="product_info">
            <h1 class="product_title h6">
                <a style="font-size: 13px;" href="{{ route('article.show', $article->slug) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $article->title }}">
                    {{ $article->title }}
                </a>
            </h1>
            <div class="product_price">
                @if ($flash = new_price($article->id))
                    <div class="price">
                        {{ devise($flash->price_new) }}
                    </div>
                    @if ($article->price_old)
                        <del>
                            {{ devise($article->price_new) }}
                        </del>
                    @endif
                @else
                    <div class="price">
                        {{ devise($article->price_new) }}
                    </div>
                    @if ($article->price_old)
                        <del>
                            {{ devise($article->price_old) }}
                        </del>
                    @endif
                @endif
            </div>
            {{-- <div class="rating_wrap">
                <div class="rating">
                    <div class="product_rate" style="width:80%"></div>
                </div>
                <span class="rating_num">(21)</span>
            </div> --}}
            {{-- <div class="pr_desc">
                <p>
                    {{ $article->content }}
                </p>
            </div> --}}
            {{-- <div class="product_size_switch">
                @foreach ($article->sizes as $item)
                    <span>
                        {{ $item->title }}
                    </span>
                @endforeach
            </div> --}}
        </div>
    </div>
</div>
