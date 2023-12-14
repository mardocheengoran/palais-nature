<!-- Footer-->
<footer class="footer pt-5" style="background-color: #e2b900;">
    <div class="container">
        <div class="row pb-2">
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">Catégories</h3>
                    <ul class="widget-list">
                        @foreach ($categories as $category)
                            <li class="widget-list-item">
                                <a class="widget-list-link" href="{{ route('article.index', $category->slug) }}">
                                    {{ $category->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">Service client</h3>
                    <ul class="widget-list">
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="{{ route('profil.index') }}">Espace client</a>
                        </li>
                        @foreach (articles($rubric = [171, 84, 79, 81]) as $article)
                            <li class="widget-list-item">
                                <a class="widget-list-link" href="{{ route('article.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                {{-- <div class="widget pb-2 mb-4">
                    <h3 class="widget-title text-light pb-1">Stay informed</h3>
                    <form class="subscription-form validate" action="https://studio.us12.list-manage.com/subscribe/post?u=c7103e2c981361a6639545bd5&amp;amp;id=29ca296126" method="post" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                        <div class="input-group flex-nowrap"><i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                            <input class="form-control rounded-start" type="email" name="EMAIL" placeholder="Your email" required>
                            <button class="btn btn-primary" type="submit" name="subscribe">Subscribe*</button>
                        </div>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true">
                            <input class="subscription-form-antispam" type="text" name="b_c7103e2c981361a6639545bd5_29ca296126" tabindex="-1">
                        </div>
                        <div class="form-text text-light opacity-50">*Subscribe to our newsletter to receive early discount offers, updates and new products info.</div>
                        <div class="subscription-status"></div>
                    </form>
                </div> --}}
                {{-- <div class="widget pb-2 mb-4">
                    <h3 class="widget-title text-light pb-1">Download our app</h3>
                    <div class="d-flex flex-wrap">
                        <div class="me-2 mb-2"><a class="btn-market btn-apple" href="#" role="button"><span class="btn-market-subtitle">Download on the</span><span class="btn-market-title">App Store</span></a></div>
                        <div class="mb-2"><a class="btn-market btn-google" href="#" role="button"><span class="btn-market-subtitle">Download on the</span><span class="btn-market-title">Google Play</span></a></div>
                    </div>
                </div> --}}
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">A propos de nous</h3>
                    <ul class="widget-list">
                        @foreach (articles($rubric = [47, 80]) as $article)
                            <li class="widget-list-item">
                                <a class="widget-list-link" href="{{ route('article.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </li>
                        @endforeach
                        <li class="widget-list-item">
                            <a class="widget-list-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">Suivez nous sur</h3>
                    <div class="ms-3 text-nowrap">
                        @foreach (specific_article($articles, 23) as $article)
                            <a {{ ($article->link == '#' or !$article->link) ? '' : 'target=_blank' }} href="{{ $article->link ? $article->link : '#' }}" class="btn-social bs-light bs-{{ $article->title }} ms-2">
                                <i class="{{ $article->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-3 bg-darker">
        <div class="container">
            {{-- <hr class="hr-light mb-2"> --}}
            {{-- <div class="row pb-2">
                <div class="col-md-6 text-center text-md-start mb-4">
                    <div class="text-nowrap mb-4"><a class="d-inline-block align-middle mt-n1 me-3" href="#"><img class="d-block" src="img/footer-logo-light.png" width="117" alt="Cartzilla"></a>
                        <div class="btn-group dropdown disable-autohide">
                            <button class="btn btn-outline-light border-light btn-sm dropdown-toggle px-2" type="button" data-bs-toggle="dropdown"><img class="me-2" src="img/flags/en.png" width="20" alt="English">Eng / $</button>
                            <ul class="dropdown-menu my-1">
                                <li class="dropdown-item">
                                    <select class="form-select form-select-sm">
                                        <option value="usd">$ USD</option>
                                        <option value="eur">€ EUR</option>
                                        <option value="ukp">£ UKP</option>
                                        <option value="jpy">¥ JPY</option>
                                    </select>
                                </li>
                                <li><a class="dropdown-item pb-1" href="#"><img class="me-2" src="img/flags/fr.png" width="20" alt="Français">Français</a></li>
                                <li><a class="dropdown-item pb-1" href="#"><img class="me-2" src="img/flags/de.png" width="20" alt="Deutsch">Deutsch</a></li>
                                <li><a class="dropdown-item" href="#"><img class="me-2" src="img/flags/it.png" width="20" alt="Italiano">Italiano</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget widget-links widget-light">
                        <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
                            <li class="widget-list-item me-4"><a class="widget-list-link" href="#">Outlets</a></li>
                            <li class="widget-list-item me-4"><a class="widget-list-link" href="#">Affiliates</a></li>
                            <li class="widget-list-item me-4"><a class="widget-list-link" href="#">Support</a></li>
                            <li class="widget-list-item me-4"><a class="widget-list-link" href="#">Privacy</a></li>
                            <li class="widget-list-item me-4"><a class="widget-list-link" href="#">Terms of use</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end mb-4">
                    <div class="mb-3">
                        <a class="btn-social bs-light bs-twitter ms-2 mb-2" href="#">
                            <i class="ci-twitter"></i>
                        </a>
                        <a class="btn-social bs-light bs-facebook ms-2 mb-2" href="#">
                            <i class="ci-facebook"></i>
                        </a>
                        <a class="btn-social bs-light bs-instagram ms-2 mb-2" href="#">
                            <i class="ci-instagram"></i>
                        </a>
                        <a class="btn-social bs-light bs-pinterest ms-2 mb-2" href="#">
                            <i class="ci-pinterest"></i>
                        </a>
                        <a class="btn-social bs-light bs-youtube ms-2 mb-2" href="#">
                            <i class="ci-youtube"></i>
                        </a>
                    </div>
                    <img class="d-inline-block" src="img/cards-alt.png" width="187" alt="Payment methods">
                </div>
            </div> --}}
            <div class="pb-4 text-light opacity-50 text-center">
                © Tous droits réservés. By
                <a class="text-light" href="https://trixa-ci.com" target="_blank" rel="noopener">
                    Trixa Agency
                </a>
            </div>
        </div>
    </div>
</footer>
