<header class="shadow-sm">
    <!-- Topbar-->
    <div class="topbar topbar-dark p-0" style="background-color: #e2b900;">
        <div class="container">
            <div class="topbar-text text-nowrap d-none d-md-inline-block">
                <i class="ci-support"></i><a class="topbar-link" href="tel:+225 0595742026">(+225) 0595742026</a>|
                <i class="ci-whatsapp"></i><a class="topbar-link" href="https://wa.me/+2250506078925" target="_blank">(+225) 0506078925</a>
            </div>
            <div class="ms-3 text-nowrap">
                @foreach (specific_article($articles, 23) as $article)
                    <a {{ ($article->link == '#' or !$article->link) ? '' : 'target=_blank' }} href="{{ $article->link ? $article->link : '#' }}" class="btn-social bs-light bs-{{ $article->title }} ms-2">
                        <i class="{{ $article->icon }}"></i>
                    </a>
                @endforeach
                {{-- <a class="btn-social bs-light bs-facebook ms-2" href="#">
                    <i class="ci-facebook"></i>
                </a>
                <a class="btn-social bs-light bs-instagram ms-2" href="#">
                    <i class="ci-instagram"></i>
                </a>
                <a class="btn-social bs-light bs-pinterest ms-2" href="#">
                    <i class="ci-tiktok"></i>
                </a> --}}
            </div>
        </div>
    </div>
    <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
    <div class="navbar-sticky bg-light">
        <div class="navbar navbar-expand-lg navbar-light p-0">
            <div class="container">
                <a class="navbar-brand d-none d-sm-block flex-shrink-0" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo.png') }}" width="100" alt="{{ setting()->title }}" />
                </a>
                <a class="navbar-brand d-sm-none flex-shrink-0 me-2" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo.png') }}" width="74" alt="{{ setting()->title }}" />
                </a>
                <div class="input-group d-none d-lg-flex mx-4">
                    <input class="form-control rounded-end pe-5" type="text" placeholder="Rechercher un produit..." />
                    <i class="ci-search position-absolute top-50 end-0 translate-middle-y text-muted fs-base me-3"></i>
                </div>
                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-tool navbar-stuck-toggler" href="#">
                        <span class="navbar-tool-tooltip">Expand menu</span>
                        <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-menu"></i></div>
                    </a>
                    {{-- <a class="navbar-tool d-none d-lg-flex" href="account-wishlist.html">
                        <span class="navbar-tool-tooltip">Wishlist</span>
                        <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-heart"></i></div>
                    </a> --}}
                    @guest
                        <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="{{ route('login') }}">
                            <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user"></i></div>
                            <div class="navbar-tool-text ms-n3">Se connecter</div>
                        </a>
                    @else
                        <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="{{ route('profil.index') }}">
                            <div class="navbar-tool-icon-box">
                                <i class="navbar-tool-icon ci-user"></i>
                            </div>
                            <div class="navbar-tool-text ms-n3">{{ Auth::user()->fullname }}</div>
                        </a>
                    @endguest

                    <div class="navbar-tool dropdown ms-3">
                        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{ route('checkout.cart') }}">
                            <span class="navbar-tool-label">{{ Cart::instance('shopping')->count() }}</span>
                            <i class="navbar-tool-icon ci-cart"></i>
                        </a>
                        <a class="" href="{{ route('checkout.cart') }}">
                            Panier
                        </a>
                        {{-- <a class="navbar-tool-text" href="{{ route('checkout.cart') }}">
                            <small>Panier</small>
                            {{ Cart::instance('shopping')->total() }}
                        </a> --}}
                        <!-- Cart dropdown-->
                        {{-- <div class="dropdown-menu dropdown-menu-end">
                            <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
                                <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">
                                    <div class="widget-cart-item pb-2 border-bottom">
                                        <button class="btn-close text-danger" type="button" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
                                        <div class="d-flex align-items-center">
                                            <a class="flex-shrink-0" href="shop-single-v1.html"><img src="img/shop/cart/widget/01.jpg" width="64" alt="Product" /></a>
                                            <div class="ps-2">
                                                <h6 class="widget-product-title"><a href="shop-single-v1.html">Women Colorblock Sneakers</a></h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent me-2">$150.<small>00</small></span><span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-cart-item py-2 border-bottom">
                                        <button class="btn-close text-danger" type="button" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
                                        <div class="d-flex align-items-center">
                                            <a class="flex-shrink-0" href="shop-single-v1.html"><img src="img/shop/cart/widget/02.jpg" width="64" alt="Product" /></a>
                                            <div class="ps-2">
                                                <h6 class="widget-product-title"><a href="shop-single-v1.html">TH Jeans City Backpack</a></h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent me-2">$79.<small>50</small></span><span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-cart-item py-2 border-bottom">
                                        <button class="btn-close text-danger" type="button" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
                                        <div class="d-flex align-items-center">
                                            <a class="flex-shrink-0" href="shop-single-v1.html"><img src="img/shop/cart/widget/03.jpg" width="64" alt="Product" /></a>
                                            <div class="ps-2">
                                                <h6 class="widget-product-title"><a href="shop-single-v1.html">3-Color Sun Stash Hat</a></h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent me-2">$22.<small>50</small></span><span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-cart-item py-2 border-bottom">
                                        <button class="btn-close text-danger" type="button" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
                                        <div class="d-flex align-items-center">
                                            <a class="flex-shrink-0" href="shop-single-v1.html"><img src="img/shop/cart/widget/04.jpg" width="64" alt="Product" /></a>
                                            <div class="ps-2">
                                                <h6 class="widget-product-title"><a href="shop-single-v1.html">Cotton Polo Regular Fit</a></h6>
                                                <div class="widget-product-meta">
                                                    <span class="text-accent me-2">$9.<small>00</small></span><span class="text-muted">x 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                                    <div class="fs-sm me-2 py-2">
                                        <span class="text-muted">Subtotal:</span><span class="text-accent fs-base ms-1">$265.<small>00</small></span>
                                    </div>
                                    <a class="btn btn-outline-secondary btn-sm" href="shop-cart.html">Expand cart<i class="ci-arrow-right ms-1 me-n1"></i></a>
                                </div>
                                <a class="btn btn-primary btn-sm d-block w-100" href="checkout-details.html"><i class="ci-card me-2 fs-base align-middle"></i>Checkout</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <!-- Search-->
                    <div class="input-group d-lg-none my-3">
                        <i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                        <input class="form-control rounded-start" type="text" placeholder="Rechercher un produit..." />
                    </div>
                    <!-- Primary menu-->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item {{ Route::is('welcome') ? 'active' : ''  }}">
                            <a class="nav-link" href="{{ route('welcome') }}">Accueil</a>
                        </li>
                        @php($i = 0)
                        @foreach ($categories as $category)
                            @php($i++)
                            <li class="nav-item {{ count($category->childrens) > 0 ? 'dropdown' : '' }} {{ (Route::is('article.index') and $category->slug == $slug) ? 'active' : '' }}">
                                <a class="nav-link {{ count($category->childrens) > 0 ? 'dropdown-toggle' : '' }}" href="{{ route('article.index', $category->slug) }}" {{ count($category->childrens) > 0 ? 'data-bs-toggle=dropdown data-bs-auto-close=outside' : '' }}>
                                    {{ $category->title }}
                                </a>
                                @if (count($category->childrens))
                                    <ul class="dropdown-menu">
                                        @foreach ($category->childrens as $item)
                                            {!! (!$loop->first) ? '<li class="dropdown-divider"></li>' : '' !!}
                                            <li>
                                                <a class="dropdown-item" href="{{ route('article.index', $item->slug) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</header>
