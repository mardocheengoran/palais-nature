<div class="bottom_header dark_skin main_menu_uppercase border-top border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                <div class="categories_wrap">
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#navCatContent" aria-expanded="false" class="categories_btn d-lg-none">
                        <i class="linearicons-menu"></i><span>Les catégories</span>
                    </button>
                    <div id="navCatContent" class="nav_cat navbar collapse">
                        <ul>
                            @php($i = 0)
                            @foreach ($categories->where('parent_id', null) as $category)
                                @php($i++)
                                @if ($i == 18) <li><ul class="more_slide_open"> @endif
                                <li class="{{ count($category->childrens) ? 'dropdown dropdown-mega-menu' : '' }}">
                                    <a class="dropdown-item nav-link {{ count($category->childrens) ? 'dropdown-toggler' : '' }}" href="{{ route('article.index', $category->slug) }}" {{ count($category->childrens) ? ' data-bs-toggle="dropdown"' : '' }}>
                                        @if(!empty($category->getMedia('icon')->first()))
                                            <img src="{{ url($category->getMedia('icon')->first()->getUrl()) }}" style="width: 20px">
                                        @else
                                            <i class="{{ $category->icon }}"></i>
                                        @endif
                                        <span>{{ $category->title }}</span>
                                    </a>
                                    @if (count($category->childrens))
                                        <div class="dropdown-menu">
                                            <ul class="mega-menu d-lg-flex">
                                                <li class="mega-menu-col col-lg-8">
                                                    <ul class="d-lg-flex">
                                                        @foreach ($category->childrens as $item)
                                                            <li class="mega-menu-col col-lg-4">
                                                                <ul>
                                                                    <li class="dropdown-header">
                                                                        <a href="{{ route('article.index', $item->slug) }}">
                                                                            {{ $item->title }}
                                                                        </a>
                                                                    </li>
                                                                    @foreach ($item->childrens as $value)
                                                                        <li>
                                                                            <a class="dropdown-item nav-link nav_item" href="{{ route('article.index', $value->slug) }}">
                                                                                {{ $value->title }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li class="mega-menu-col col-lg-4">
                                                    <div class="header-banner2">
                                                        @if(!empty($category->getMedia('image')->first()))
                                                            <img src="{{ url($category->getMedia('image')->first()->getUrl('thumb')) }}" class="img-fluid">
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                    {{-- <li class="mega-menu-col col-lg-4">
                                        <ul>
                                            <li class="dropdown-header">Men's</li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Donec vitae ante ante</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Etiam ac rutrum</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Quisque condimentum</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="compare.html">Curabitur laoreet</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Vivamus in tortor</a></li>
                                        </ul>
                                    </li> --}}
                                </li>
                                @if($loop->last and $i > 18) </li></ul> @endif
                            @endforeach
                            {{-- <li>
                                <a class="dropdown-item nav-link nav_item" href="coming-soon.html">
                                    <i class="flaticon-tv"></i> <span>Informatique</span>
                                </a>
                            </li> --}}
                        </ul>
                        {{-- <div class="more_categories">Plus de catégories</div> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-6 col-9 d-lg-none">
                <nav class="navbar navbar-expand-lg" style="justify-content: end !important;">
                    {{-- <button class="navbar-toggler side_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSidetoggle" aria-expanded="false">
                        <span class="ion-android-menu"></span>
                    </button> --}}
                    <div class="pr_search_icon">
                        <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                    </div>
                    {{-- <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                        <ul class="navbar-nav">
                            <li class="dropdown">
                                <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle active" href="#">Home</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="index.html">Fashion 1</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="index-2.html">Fashion 2</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="index-3.html">Furniture 1</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="index-4.html">Furniture 2</a></li>
                                        <li><a class="dropdown-item nav-link nav_item active" href="index-5.html">Electronics 1</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="index-6.html">Electronics 2</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="about.html">About Us</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="contact.html">Contact Us</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="faq.html">Faq</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="404.html">404 Error Page</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="login.html">Login</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="signup.html">Register</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="term-condition.html">Terms and Conditions</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown dropdown-mega-menu">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                                <div class="dropdown-menu">
                                    <ul class="mega-menu d-lg-flex">
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">Woman's</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">Vestibulum sed</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Donec porttitor</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Donec vitae facilisis</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">Curabitur tempus</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Vivamus in tortor</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">Men's</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Donec vitae ante ante</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Etiam ac rutrum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Quisque condimentum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="compare.html">Curabitur laoreet</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Vivamus in tortor</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">Kid's</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">Accessories</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="px-3 d-lg-flex menu_banners row g-3">
                                        <div class="col-lg-6">
                                            <div class="header-banner">
                                                <div class="sale-banner">
                                                    <a class="hover_effect1" href="#">
                                                        <img src="assets/images/shop_banner_img7.jpg" alt="shop_banner_img7">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="header-banner">
                                                <div class="sale-banner">
                                                    <a class="hover_effect1" href="#">
                                                        <img src="assets/images/shop_banner_img8.jpg" alt="shop_banner_img8">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Blog</a>
                                <div class="dropdown-menu dropdown-reverse">
                                    <ul>
                                        <li>
                                            <a class="dropdown-item menu-link dropdown-toggler" href="#">Grids</a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-three-columns.html">3 columns</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-four-columns.html">4 columns</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-left-sidebar.html">Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-right-sidebar.html">right Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-standard-left-sidebar.html">Standard Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-standard-right-sidebar.html">Standard right Sidebar</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item menu-link dropdown-toggler" href="#">Masonry</a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-three-columns.html">3 columns</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-four-columns.html">4 columns</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-left-sidebar.html">Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-right-sidebar.html">right Sidebar</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item menu-link dropdown-toggler" href="#">Single Post</a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single.html">Default</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-left-sidebar.html">left sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-slider.html">slider post</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-video.html">video post</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-single-audio.html">audio post</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item menu-link dropdown-toggler" href="#">List</a>
                                            <div class="dropdown-menu">
                                                <ul>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-list-left-sidebar.html">left sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="blog-list-right-sidebar.html">right sidebar</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown dropdown-mega-menu">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Shop</a>
                                <div class="dropdown-menu">
                                    <ul class="mega-menu d-lg-flex">
                                        <li class="mega-menu-col col-lg-9">
                                            <ul class="d-lg-flex">
                                                <li class="mega-menu-col col-lg-4">
                                                    <ul>
                                                        <li class="dropdown-header">Shop Page Layout</li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">shop List view</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">shop List Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-list-right-sidebar.html">shop List Right Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Right Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Shop Load More</a></li>
                                                    </ul>
                                                </li>
                                                <li class="mega-menu-col col-lg-4">
                                                    <ul>
                                                        <li class="dropdown-header">Other Pages</li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Cart</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Checkout</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="my-account.html">My Account</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Wishlist</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="compare.html">compare</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Order Completed</a></li>
                                                    </ul>
                                                </li>
                                                <li class="mega-menu-col col-lg-4">
                                                    <ul>
                                                        <li class="dropdown-header">Product Pages</li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Default</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Right Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Thumbnails Left</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <div class="header_banner">
                                                <div class="header_banner_content">
                                                    <div class="shop_banner">
                                                        <div class="banner_img overlay_bg_40">
                                                            <img src="assets/images/shop_banner3.jpg" alt="shop_banner"/>
                                                        </div>
                                                        <div class="shop_bn_content">
                                                            <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                            <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                            <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Acheter maintenant</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li><a class="nav-link nav_item" href="contact.html">Contact Us</a></li>
                        </ul>
                    </div> --}}
                    <div class="contact_phone contact_support">
                        <a href="tel:+225 0703334624" target="_blank" {{--  class="nav-link text-warning" --}}>
                            <i class="linearicons-phone-wave"></i>
                            <span>07 03 33 46 24</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
