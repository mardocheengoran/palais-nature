<div>
    @push('style')
    @endpush

    <section class="bg-dark-dark">
        <div
            class=" overflow-hidden bg-cover bg-size--cover"
            data-spotlight="fullscreen"
            style="background-image: url('{{ $setting->getMedia('cover')->first() ? url($setting->getMedia('cover')->first()->getUrl('normal')) : '' }}'); background-position: center center;"
            data-separator="rounded-right"
            data-separator-orientation="bottom">
            <span class="mask bg-gradient-dark opacity-7"></span>
            <div class="container py-10 d-flex align-items-center">
                <div class="col pt-6 pt-lg-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <h1 class="text-white text-uppercase">
                                Devis
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="pb-0 slice bg-section-secondary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body mx-auto-4">
                            {{-- @if ($errors->any())
                                <div class='alert alert-danger' role="alert">
                                    <div class="font-weight-bold">{{ __('Quelque chose s\'est mal passé.') }}</div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            <form {{-- action="{{ route('contact.store') }}" method="POST" --}}>
                                {{-- @csrf --}}
                                <div class="row mx-auto-2">
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="entreprise">Nom de l’entreprise </label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="entreprise" wire:keydown.enter.prevent="store" class="form-control" id="entreprise" placeholder="" required />
                                        @error('entreprise')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="phone">Contact téléphonique</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="phone" wire:keydown.enter.prevent="store" class="form-control" id="phone" placeholder="" required />
                                        @error('phone')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="email">Adresse E-mail</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="email" wire:keydown.enter.prevent="store" class="form-control" id="email" placeholder="" required />
                                        @error('email')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="nature">Nature de la marchandise</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="nature" wire:keydown.enter.prevent="store" class="form-control" id="nature" placeholder="" required />
                                        @error('nature')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="hscode">HS Code</label>
                                        <input type="text" wire:model.defer="hscode" wire:keydown.enter.prevent="store" class="form-control" id="hscode" placeholder="" />
                                        @error('hscode')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="poids">Poids de la marchandise</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="poids" wire:keydown.enter.prevent="store" class="form-control" id="poids" placeholder="" required />
                                        @error('poids')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="shipping">Shipping Terms</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="shipping" wire:keydown.enter.prevent="store" id="shipping">
                                            <option>---------------</option>
                                            <option>FCL</option>
                                            <option>LCL</option>
                                        </select>
                                        @error('shipping')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="conteneur">Type de conteneur</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control" wire:model.defer="conteneur" wire:keydown.enter.prevent="store" id="conteneur">
                                            <option>---------------</option>
                                            <option>20GP</option>
                                            <option>40GP</option>
                                            <option>20OT</option>
                                            <option>40OT</option>
                                            <option>20FR</option>
                                            <option>40FR</option>
                                            <option>40RF</option>
                                            <option>Autres</option>
                                        </select>
                                        @error('conteneur')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="port">Port de chargement</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="port" wire:keydown.enter.prevent="store" class="form-control" id="port" placeholder="" required />
                                        @error('port')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="enlevement">Adresse d’enlèvement de la marchandise</label>
                                        <input type="text" wire:model.defer="enlevement" wire:keydown.enter.prevent="store" class="form-control" id="enlevement" placeholder="" />
                                        @error('enlevement')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="dechargement">Port de déchargement</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="dechargement" wire:keydown.enter.prevent="store" class="form-control" id="dechargement" placeholder="" required />
                                        @error('dechargement')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="livraison">Adresse de livraison</label>
                                        <input type="text" wire:model.defer="livraison" wire:keydown.enter.prevent="store" class="form-control" id="livraison" placeholder="" />
                                        @error('livraison')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="commentaire">Commentaires</label>
                                            <span class="text-danger">*</span>
                                            <textarea class="form-control" wire:model.defer="commentaire" id="commentaire" rows="3" placeholder="Votre message..."></textarea>
                                            @error('commentaire')
                                                <div class="text-center text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    {{-- <button wire:click="store" class="btn btn-warning btn-block" type="submit">Envoyer votre message</button> --}}

                                    <button type="button" wire:click="store" wire:loading.class="bg-dark" wire:loading.attr="disabled" class="mt-4 btn btn-dark btn-shadow btn-block text-uppercase" href="#">
                                        <i class="mr-2 icofont-paper-plane font-size-lg"></i> Envoyer votre message
                                        <div wire:loading wire:target="store">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    @endpush
</div>
