<!-- Sidebar-->
<aside class="order-1 pt-4 col-lg-3 pt-lg-0 order-lg-0 mt-3">
    <div data-toggle="sticky" data-sticky-offset="30" class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
        <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-3">
            <div class="{{-- d-md-flex align-items-center --}} text-center mx-auto">
                <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0 text-center" style="width: 6.375rem;">
                    {{-- <span class="badge bg-warning position-absolute end-0 mt-n2" data-bs-toggle="tooltip" title="Reward points">384</span> --}}
                    @if(!empty(auth()->user()->getMedia('image')->first()))
                        <img class="rounded-circle" src="{{ url(auth()->user()->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ auth()->user()->fullname }}">
                    @else
                        <img class="rounded-circle" src="{{ asset('img/user.png') }}" alt="{{ auth()->user()->fullname }}">
                    @endif
                </div>
                <div class="{{-- ps-md-3 --}}">
                    <h3 class="fs-base mb-0">
                        {{ auth()->user()->fullname }}
                    </h3>
                    <span class="text-accent fs-sm">
                        {{ auth()->user()->email }}
                    </span>
                </div>
            </div>
            <a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false">
                <i class="ci-menu me-2"></i>Menu personnel
            </a>
        </div>
        <div class="d-lg-block collapse" id="account-menu">
            {{-- <div class="bg-secondary px-4 py-3">
                <h3 class="fs-sm mb-0 text-muted">Tableau de bord</h3>
            </div> --}}
            <ul class="mb-0 list-unstyled">
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ Route::is('profil.index') ? 'active' : '' }}" href="{{ route('profil.index') }}">
                        <i class="ci-user opacity-60 me-2"></i>
                        <span class="pr-5"> Mon profil</span>
                    </a>
                </li>
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ Route::is('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="icofont-thin-double-right"></i>
                        <span class="pr-5"> Modifier profil</span>
                    </a>
                </li>
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ Route::is('invoice.all') ? 'active' : '' }}" href="{{ route('invoice.all') }}">
                        <i class="ci-bag opacity-60 me-2"></i>
                        <span class="pr-5"> Commandes </span>
                        <span class="fs-sm text-muted ms-auto">
                            @isset ($user->invoices_check) {{ count($user->invoices_check) }} @endisset
                        </span>
                    </a>
                </li>
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ Route::is('wishlist') ? 'active' : '' }}" href="{{ route('wishlist') }}">
                        <i class="ci-heart opacity-60 me-2"></i>
                        Liste d'envies
                        <span class="fs-sm text-muted ms-auto">
                            {{ Cart::instance('wishlist')->count() }}
                        </span>
                    </a>
                </li>
                {{-- <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3" href="#" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="icofont-thin-double-right"></i>
                        Mes filleuls directs
                        <span class="ml-auto font-size-sm text-muted">
                            {{ count($user->childrens) }}
                        </span>
                    </a>
                </li>
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3" href="#" data-toggle="modal" data-target=".solde-gain">
                        <i class="icofont-thin-double-right"></i>
                        Solde
                        <span class="ml-auto font-size-sm text-muted">
                            {{ devise(calcul_gain($user)) }}
                        </span>
                    </a>
                </li>
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('demande.index') }}">
                        <i class="icofont-thin-double-right"></i>
                        Demande de paiement
                    </a>
                </li> --}}
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('profile.show') }}#update-password">
                        <i class="icofont-ssl-security"></i>
                        Changer mot de passe
                    </a>
                </li>
                {{-- <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3" href="#">
                        <i class="icofont-thin-double-right"></i>
                        Photo de profil
                    </a>
                </li> --}}
                <li class="border-bottom mb-0">
                    <a class="nav-link-style d-flex align-items-center px-4 py-3 {{ Route::is('profil.history') ? 'active' : '' }}" href="{{ route('profil.history') }}">
                        <i class="icofont-history"></i>
                        Vus récemment
                    </a>
                </li>

                <li class="border-bottom mb-0">
                    <a class="px-4 py-3 nav-link-style d-flex align-items-center text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="icofont-logout"></i> Décconexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>
