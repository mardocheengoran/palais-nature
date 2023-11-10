<div>
    @include('layouts.header')
    <div class="container mt-6 mb-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-8 col-xl-8">

                {{-- @foreach ($errors->all() as $error)
                    <p class="text-center text-danger">{{ $error }}</p>
                @endforeach --}}
                <h6 class="mb-3 text-center h3 text-uppercase">Créer un compte</h6>
                <span class="clearfix"></span>
                <form method="POST" {{-- action="{{ route('register') }}" --}} class="form-box">
                    @csrf
                    @isset ($user)
                        <h5 class="text-center text-danger">
                            Votre parrain : <strong>{{ $user->matricule }}</strong>
                        </h5>
                    @endisset

                    @if ($supplier == 'fournisseur')
                        <div class="mb-3 shadow card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="pr-0 col-12">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Nom de votre boutique <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icofont-food-cart"></i></span>
                                                </div>
                                                <input id="store" type="text" class="form-control @error('store') is-invalid @enderror" wire:model='store'  name="store" value="{{ old('store') }}" required autocomplete="store">
                                                @error('store')
                                                    <span class="text-center text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pr-0 col-12">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Commune <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="icofont-flag"></i>
                                                    </span>
                                                </div>
                                                <select required class="form-control  @error('city_id') is-invalid @enderror" name="city_id" wire:model='city_id' id="city_id">
                                                    <option value="">--------</option>
                                                    @foreach ($cities as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
                                                    <span class="text-center text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pr-0 col-12">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Localisaton exact de votre boutique <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="icofont-google-map"></i>
                                                    </span>
                                                </div>
                                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" wire:model='address'  name="address" value="{{ old('address') }}" required autocomplete="address">
                                                @error('address')
                                                    <span class="text-center text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pr-0 col-12">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Images de votre boutique
                                            </label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icofont-image"></i></span>
                                                </div>
                                                <input id="store" type="file" class="form-control @error('image') is-invalid @enderror" wire:model='image'  name="image" value="{{ old('image') }}" autocomplete="image">
                                                @error('image')
                                                    <span class="text-center text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($supplier == 'livreur')
                    <div class="mb-3 shadow card">
                        <div class="card-body">
                            <div class="row">
                                <div class="pr-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Etes-vous une société de livraison ou une personne physique
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icofont-flag"></i>
                                                </span>
                                            </div>
                                            <select required class="form-control  @error('entity_id') is-invalid @enderror" name="entity_id" wire:model='entity_id' id="entity_id">
                                                <option value="">Selectionnez un status</option>
                                                @foreach ($entities as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('entity_id')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="pr-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Quel est votre type de véhicule
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge mt-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icofont-truck"></i>
                                                </span>
                                            </div>
                                            <select required class="form-control  @error('vehicle_id') is-invalid @enderror" name="vehicle_id" wire:model='vehicle_id' id="vehicle_id">
                                                <option value="">Selectionnez un véhicule</option>
                                                @foreach ($vehicles as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vehicle_id')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="pr-0 col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Description
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icofont-list"></i></span>
                                            </div>
                                            <textarea placeholder="{{ __('Description') }}" id="content" type="text" class="form-control @error('content') is-invalid @enderror" wire:model='content'  name="content" value="{{ old('content') }}"  autocomplete="content" aria-label="With textarea"></textarea>
                                            @error('content')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="shadow card">
                        <div class="card-body">
                            <div class="row">
                                <div class="pr-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Nom <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input placeholder="{{ __('Nom') }}" id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" wire:model='last_name'  name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                                            @error('last_name')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Prénoms <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input placeholder="{{ __('Prénoms') }}" id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" wire:model='first_name' name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="pr-0 col-3">
                                    <div class="input-group input-group-merge">
                                        <input required id="indicatif_telephone" type="text" class="form-control input-mask @error('indicatif_telephone') is-invalid @enderror" name="indicatif_telephone" value="225" data-mask="000" placeholder="225">
                                        @error('indicatif_telephone')
                                            <span class="text-center text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="pr-0 col-6">
                                    <label class="form-control-label">
                                        Numéro de téléphone <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                        </div>
                                        <input required id="phone" type="text" class="form-control input-mask @error('phone') is-invalid @enderror" wire:model='phone' name="phone" value="{{ old('phone') }}" autocomplete="phone" data-mask="00 00 00 00 00" placeholder="00 00 00 00 00">
                                        @error('phone')
                                            <span class="text-center text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="pl-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input required placeholder="{{ __('Email') }}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model='email' name="email" value="{{ old('email') }}" autocomplete="email">
                                            @error('email')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="pr-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Mot de passe <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input placeholder="{{ __('Mot de passe') }}" id="password" type="password" class="form-control @error('password') is-invalid @enderror" wire:model='password' name="password" required autocomplete="new-password">
                                            @error('password')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            {{-- <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-0 col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">
                                            Confirmation de mot de passe <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input placeholder="{{ __('Confirmer le mot de passe') }}" id="password-confirm" type="password" class="form-control" wire:model='password_confirmation' name="password_confirmation" required autocomplete="new-password">
                                            @error('password_confirmation')
                                                <span class="text-center text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-2">
                                <div class="custom-control custom-checkbox">
                                    <input wire:model='terms' type="checkbox" class="custom-control-input" id="check-terms" />
                                    <label class="custom-control-label" for="check-terms">
                                        <span class="ms-4">
                                            J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#modal_1">termes et conditions</a>
                                        </span>
                                    </label>
                                </div>
                                @error('terms')
                                    <span class="text-center text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" wire:loading.class="text-white bg-dark" wire:loading.attr="disabled" wire:click='next' class="btn btn-warning btn-icon rounded-pill btn-lg btn-block">
                            <span class="btn-inner--text">Créer mon compte</span>
                            <span class="btn-inner--icon"><i class="fas fa-long-arrow-alt-right"></i></span>
                            <div wire:loading wire:target='next'>
                                <span class="spinner-border spinner-border-sm"></span>
                            </div>
                        </button>
                    </div>
                </form>
                <div class="pt-2 px-md-5">
                    <small>Vous avez déjà un compte ?</small>
                    <a href="{{ route('login') }}" class="small font-weight-bold">Connectez-vous</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-fluid fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="modal_1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Termes et conditions
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        {!! find_article(80)->content !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.qenium.com/asset/libs/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    @endpush
</div>