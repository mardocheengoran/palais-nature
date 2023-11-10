<!-- Home Popup Section -->
{{-- <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row g-0">
                    <div class="col-sm-7">
                        <div class="popup_content text-start">
                            <div class="popup-text">
                                <div class="heading_s1">
                                    <h3>Subscribe Newsletter and Get 25% Discount!</h3>
                                </div>
                                <p>Subscribe to the newsletter to receive updates about new products.</p>
                            </div>
                            <form method="post">
                                <div class="mb-3 form-group">
                                    <input name="email" required type="email" class="form-control" placeholder="Enter Your Email">
                                </div>
                                <div class="mb-3 form-group">
                                    <button class="btn btn-fill-out btn-block text-uppercase" title="Subscribe" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="background_bg h-100" data-img-src="assets/images/popup_img3.jpg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- End Screen Load Popup Section -->
@include('layouts.admin-bar')

@guest
    <div class="py-1 top-header light_skin bg_dark d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="px-5 col-lg-12 col-md-12">
                    <div class="header_topbar_info">
                        <div class="header_offer">
                            <a class="text-white" href="{{ route('register') }}?supplier=fournisseur">
                                Devenez vendeur sur Bezo
                            </a>
                        </div>
                        {{-- <div class="download_wrap">
                            <span class="me-3">Téléchargez l'application sur</span>
                            <ul class="text-center icon_list text-lg-start">
                                <li><a href="#"><i class="fab fa-apple"></i></a></li>
                                <li><a href="#"><i class="fab fa-android"></i></a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-6 col-md-4">
                    {{--  <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="lng_dropdown">
                            <select name="countries" class="custome_select">
                                <option value='en' data-image="assets/images/eng.png" data-title="English">English</option>
                                <option value='fn' data-image="assets/images/fn.png" data-title="France">France</option>
                                <option value='us' data-image="assets/images/us.png" data-title="United States">United States</option>
                            </select>
                        </div>
                        <div class="ms-3">
                            <select name="countries" class="custome_select">
                                <option value='USD' data-title="USD">USD</option>
                                <option value='EUR' data-title="EUR">EUR</option>
                                <option value='GBR' data-title="GBR">GBR</option>
                            </select>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endguest
<div class="bg_warning d-none d-md-block">
    <div class="container">
        <div class="p-2 text-center text-white h4">
            -30% sur vos produits tech et livraison gratuite jusqu'au 25 Mai 2023!!
        </div>
    </div>
</div>

<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <div class="nav_block">
                @if (!Route::is('welcome'))
                    <div>
                        @include('layouts.menu')
                    </div>
                @endif
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    <img class="pe-5 d-block" style="width: 300px" src="{{ asset('img/logo.png')}}" alt="{{ setting()->title }}" />
                </a>
                <livewire:search />
                {{-- <div class="">
                    <a class="btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown" id="book-dorpdown" aria-expanded="true">
                        <i class="linearicons-user"></i> Se connecter</a>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="book-dropdown">
                        <li><a class="dropdown-item" href="#"> <i class="linearicons-user"></i>Mon Compte</a></li>
                        <li><a class="dropdown-item" href="#"><i class="linearicons-bag"></i>Vos commandes</a></li>
                        <li><a class="dropdown-item" href="#"><i class="linearicons-heart"></i>Votre liste d'envies</a></li>
                        <li><hr class="dropdown-divider" style="opacity:0.4;"></li>
                        <li><a class="dropdown-item" href="#"><i class="linearicons-power-switch"></i> Deconnexion</a></li>
                    </ul>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="linearicons-user"></i>Mon compte</a>
                        </a>
                        @auth
                             <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#"> <i class="linearicons-user"></i>Mon Compte</a></li>
                                <li><a class="dropdown-item" href="#"><i class="linearicons-bag"></i>Vos commandes</a></li>
                                <li><a class="dropdown-item" href="#"><i class="linearicons-heart"></i>Votre liste d'envies</a></li>
                                <li><hr class="dropdown-divider" style="opacity:0.4;"></li>
                                <li><a class="dropdown-item" href="#"><i class="linearicons-power-switch"></i> Deconnexion</a></li>
                            </ul>
                        @else
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Se connecter</a></li>
                                <li><a class="dropdown-item" href="#">S'inscrire</a></li>
                            </ul>
                        @endauth
                    </div>
                </div> --}}
                <div class="px-3">
                    <ul class="navbar-nav attr-nav align-items-center">
                        <li>
                            <nav class="navbar navbar-expand-lg" style="justify-content: end !important;">
                                <ul class="navbar-nav">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle nav-link" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown">
                                            <i class="linearicons-user"></i>
                                        </a>
                                        @auth
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" href="{{ route('profil.index') }}"> <i class="linearicons-user"></i>Mon Compte</a></li>
                                                <li><a class="dropdown-item" href="{{ route('invoice.all') }}"><i class="linearicons-bag"></i>Vos commandes</a></li>
                                                <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="linearicons-heart"></i>Votre liste d'envies</a></li>
                                                <li><hr class="dropdown-divider" style="opacity:0.4;"></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                        <i class="linearicons-power-switch"></i> Déconnexion
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        @else
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
                                                <li><a class="dropdown-item" href="{{ route('register') }}">S'inscrire</a></li>
                                            </ul>
                                        @endauth
                                    </li>
                                </ul>
                            </nav>
                        </li>
                        {{-- <li>
                            <a href="#" class="nav-link">
                                <i class="linearicons-heart"></i>
                                <span class="wishlist_count">0</span>
                            </a>
                        </li> --}}
                        <li class="dropdown cart_dropdown">
                            <a class="nav-link cart_trigger" href="{{ route('checkout.cart') }}" {{-- data-bs-toggle="dropdown" --}}>
                                <i class="linearicons-cart-add"></i>
                                <span class="cart_count">
                                    {{ Cart::instance('shopping')->count() }}
                                </span>
                                Panier
                            </a>
                            {{-- <div class="cart_box cart_right dropdown-menu dropdown-menu-right">
                                <ul class="cart_list">
                                    <li>
                                        <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                        <a href="#"><img src="{{ asset('img/chose.jpg') }}" alt="cart_thumb1">Produit 1</a>
                                        <span class="cart_quantity"> 2 x <span class="cart_amount"> </span>15 000 <span class="price_symbole">Fr</span> </span>
                                    </li>
                                    <li>
                                        <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                        <a href="#"><img width="100" src="{{ asset('img/fem.jpg') }}" alt="cart_thumb2">Produit 2</a>
                                        <span class="cart_quantity"> 1 x <span class="cart_amount"> </span>20 000 <span class="price_symbole">Fr</span> </span>
                                    </li>
                                </ul>
                                <div class="cart_footer">
                                    <p class="cart_total"><strong>Total:</strong> <span class="cart_price"> </span>50 000 <span class="price_symbole">Fr</span> </p>
                                    <p class="cart_buttons"><a href="#" class="btn btn-fill-line view-cart">Voir</a><a href="#" class="btn btn-fill-out checkout">Retirer</a></p>
                                </div>
                            </div> --}}
                        </li>
                        <li class="d-none d-lg-inline-block">
                            <a href="tel:+225 0703334624" class="nav-link text-warning">
                                <i class="linearicons-phone-wave"></i>
                                0703334624
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->
@if (Route::is('welcome'))
    @include('layouts.vertical-menu')
@endif
