<!-- Sidebar-->
<aside class="order-1 pt-4 col-lg-4 pt-lg-0 order-lg-0 mt-3">
    <div data-toggle="sticky" data-sticky-offset="30">
        <div class="p-3 pt-0 text-center card-body">
            <div class="">
                <ul class="mb-0 list-unstyled">
                    <li class="list-group-item bg-light">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="{{ route('profil.index') }}">
                            <i class="icofont-thin-double-right"></i>
                            <span class="pr-5"> Mon profil</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="{{ route('profile.show') }}">
                            <i class="icofont-thin-double-right"></i>
                            <span class="pr-5"> Modifier profil</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="#">
                            <i class="icofont-thin-double-right"></i>
                            <span class="pr-5"> Commandes </span>
                            <span class="ml-auto font-size-sm badge badge-primary badge-circle">
                                @isset ($user->commandes) {{ count($user->commandes) }} @endisset
                            </span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="{{ route('wishlist') }}">
                            <i class="icofont-thin-double-right"></i>
                            Liste d'envies
                            <span class="cart_count float-right">
                                {{ Cart::instance('wishlist')->count() }}
                            </span>
                        </a>
                    </li>
                    {{-- <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="#" data-toggle="modal" data-target=".bd-example-modal-xl">
                            <i class="icofont-thin-double-right"></i>
                            Mes filleuls directs
                            <span class="ml-auto font-size-sm text-muted">
                                {{ count($user->childrens) }}
                            </span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="#" data-toggle="modal" data-target=".solde-gain">
                            <i class="icofont-thin-double-right"></i>
                            Solde
                            <span class="ml-auto font-size-sm text-muted">
                                {{ devise(calcul_gain($user)) }}
                            </span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="{{ route('demande.index') }}">
                            <i class="icofont-thin-double-right"></i>
                            Demande de paiement
                        </a>
                    </li> --}}
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="{{ route('profile.show') }}#update-password">
                            <i class="icofont-thin-double-right"></i>
                            Changer mot de passe
                        </a>
                    </li>
                    {{-- <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="#">
                            <i class="icofont-thin-double-right"></i>
                            Photo de profil
                        </a>
                    </li> --}}
                    <li class="list-group-item">
                        <a class="py-1 nav-link-style d-flex align-items-center" href="{{ route('profil.history') }}">
                            <i class="icofont-history"></i>
                            Vus récemment
                        </a>
                    </li>

                    <li class="list-group-item">
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
    </div>
</aside>
