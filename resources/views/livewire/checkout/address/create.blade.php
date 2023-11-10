<div wire:ignore.self class="modal fade subscribe_popup" id="address" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @isset($valeur)
                        Modifier adresse de livraison
                    @else
                        Nouvelle adresse de livraison
                    @endisset
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
            </div>
            <div class="p-3 modal-body">
                <div class="row">
                    {{-- <div class="col-sm-6">
                        <div class="form-group">
                            <label for="country">
                                Pays <span class="text-danger">*</span>
                            </label>
                            <select name="country" class="custom-select" id="country" required>
                                <option value="">-------Pays-------</option>
                                @foreach ($countries as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == 110) ? 'selected' : '' }}>
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Choisissez votre pays!</div>
                            @error('pays_id')
                                <div class="text-center text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">
                                Lieu de livraison exact <span class="text-danger">*</span>
                            </label>
                            <input wire:model='title' name="title" class="form-control" type="text" id="title" required>
                            <div class="invalid-feedback">Veuillez indiquer votre lieu de livraison !</div>
                            @error('title')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address-city">
                                Ville <span class="text-danger">*</span>
                            </label>
                            {{-- <input value="{{ old('ville') }}" name="ville" class="form-control" type="text" id="address-city" required> --}}
                            <select wire:model='city' name="city" class="custom-select" id="city" required>
                                <option value="">-------Commune-------</option>
                                @foreach ($cities as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == 110) ? 'selected' : '' }}>
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                                @error('city')
                                    <div class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </select>
                            @error('city')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror

                            @if ($city == 270)
                               <div class="form-group mb-3">
                                    <label for="location" class="form-label">
                                        Nom de la ville <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" wire:model='location' class="form-control"  id="location" placeholder="Yamoussoukro" required>
                              </div>  
                            @endif
                            @error('location')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="subtitle">
                                N°téléphone <span class="text-danger">*</span>
                            </label>
                            <input wire:model='subtitle' name="subtitle" class="form-control" type="text" id="subtitle" required>
                            @error('city')
                                <div class="text-danger">
                                    <strong>Veuillez indiquer votre numéro de téléphone !</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal" aria-label="Close">
                    Fermer
                </button>
                <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click.prevent="addressStore" class="btn btn-warning btn-shadow btn-sm">
                    @isset($valeur)
                        Modifier
                    @else
                        Enregistrer
                    @endisset
                    <div wire:loading wire:target='addressStore'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                    {{-- <div wire:loading wire:target="store" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden"></span>
                    </div> --}}
                </button>
            </div>
        </div>
    </div>
</div>
