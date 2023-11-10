<div class="section bg-dark small_pt small_pb">
	<div class="container">
    	<div class="row align-items-center">
            <div class="col-md-2 text-center">
                <img src="{{ asset('img/logo-blanc.png') }}" alt="Bezo" class="img-fluid" width="170">
            	{{-- <div class="text_white">
                    <div class="h5 fw-bold">Rejoignez notre newsletter</div>
                    <p>
                        Inscrivez-vous maintenant pour obtenir des mises à jour sur les promotions.
                    </p>
                </div> --}}
            </div>
            <div class="col-md-7">
                <div class="newsletter_form2 rounded_input">
                    {{-- <form>
                        <input type="text" required="" class="form-control" placeholder="Entez l'adresse email">
                        <button type="submit" class="btn btn-dark btn-radius" name="submit" value="Submit">
                            <i class="icofont-envelope-open"></i>
                        </button>
                    </form> --}}
                    <div class="h5 fw-bold">Rejoignez notre newsletter</div>
                    <p>
                        Inscrivez-vous maintenant pour obtenir des mises à jour sur les promotions.
                    </p>

                    {{-- @include('layouts.newsletter-homme') --}}
                    <livewire:newsletter>

                    {{-- <form>
                        <div class="input-group">
                            <input class="input form-control" type="email" id="email" wire:model="email" name="email" autocomplete="off" placeholder="Entrez l'adresse email" required>
                            <button wire:click="send" wire:loading.attr="disabled" type="button" class="btn btn-secondary">
                                HOMME
                                <div wire:loading wire:target='send(homme)'>
                                    <span class="spinner-border spinner-border-sm"></span>
                                </div>
                            </button>
                            <button wire:click="send(femme)" type="button" class="btn btn-secondary">
                                FEMME
                            </button>
                        </div>
                        @error('email')
                            <div class="text-center text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </form> --}}
                </div>
            </div>
            <div class="col-md-3">
            	<div class="text_white">
                    <div class="text-warning">L’APP Bezo</div>
                    <div>Disponible gratuitement</div>
                    <a href="#">
                        <img src="{{ asset('img/appstore.png') }}" alt="" class="w-25">
                    </a>
                    <a href="#">
                        <img src="{{ asset('img/playstore.png') }}" alt="" class="w-25">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START FOOTER -->
<footer class="bg_dark4">
    <div class="footer_top small_pt pb_20">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Service client</h6>
                        <ul class="widget_links">
                            @foreach (articles($rubric = [171, 84, 79, 81]) as $article)
                                <li>
                                    <a href="{{ route('article.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </li>
                            @endforeach
                            <li><a href="{{ route('signal') }}">Signaler un produit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">A propos de nous</h6>
                        <ul class="widget_links">
                            @foreach (articles($rubric = [47, 80]) as $article)
                                <li>
                                    <a href="{{ route('article.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </li>
                            @endforeach
                            <li><a href="#">Carrières chez Bezo</a></li>
                            <li><a href="{{ route('boutique.index') }}">Toutes les boutiques</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Programme partenaire</h6>
                        <ul class="widget_links">
                            <li><a href="{{ route('register') }}?supplier=fournisseur">Adhésions fournisseurs</a></li>
                            <li><a href="{{ route('register') }}?supplier=livreur">Partenaire logistique</a></li>
                            {{-- <li><a href="#">Points relai</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="widget">
                        <h6 class="widget_title">Suivez-nous sur</h6>
                        <div class="widget mb-lg-0">
                            <ul class="text-center social_icons text-lg-start">
                                @foreach (specific_article($articles, 23) as $article)
                                    <li>
                                        <a {{ ($article->link == '#' or !$article->link) ? '' : 'target="_blank"' }} href="{{ $article->link ? $article->link : '#' }}" class="rounded-circle sc_{{ $article->title }}">
                                            <i class="{{ $article->icon }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 middle_footer">
        <div class="container">
            <div class="row">
                @foreach (specific_article($articles, 267) as $article)
                    <div class="text-center col-md-3">
                        <div class="">
                            <div class="text-white h6 fw-bolder">{{ $article->title }}</div>
                        </div>
                        @if(!empty($article->getMedia('image')->first()))
                            <div class="">
                                <img class="img-fluid" style="width: 60px;" src="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                            </div>
                        @endif
                    </div>
                @endforeach
                <div class="col-lg-3">
                    <div class="mb-4">
                        <div class="text-white h6 fw-bolder">Mode de paiement</div>
                    </div>
                    <ul class="text-center footer_payment text-lg-end">
                        @foreach (specific_article($articles, 268) as $article)
                            <li>
                                @if(!empty($article->getMedia('image')->first()))
                                    <img style="height: 20px;" src="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="col-md-4">
                    <div class="icon_box icon_box_style2">
                        <div class="icon">
                            <i class="flaticon-money-back"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>30 Day Returns Guarantee</h5>
                            <p>Phasellus blandit massa enim elit of passage varius nunc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon_box icon_box_style2">
                        <div class="icon">
                            <i class="flaticon-support"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>27/4 Online Support</h5>
                            <p>Phasellus blandit massa enim elit of passage varius nunc.</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <p class="text-center mb-lg-0">
                        © 2023 Tous droits reservés by
                        <a style="color: #687188;" href="https://www.qenium.com" target="_blank">Qenium</a>
                    </p>
                </div>
                <div class="col-lg-4 order-lg-first">

                </div>

            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>
