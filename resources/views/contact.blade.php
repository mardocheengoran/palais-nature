<div>
    @push('style')
    @endpush

    @include('layouts.header')

    <div class="breadcrumb_section page-title-mini bg-category" style="background-image: url('{{ $setting->getMedia('cover')->first() ? url($setting->getMedia('cover')->first()->getUrl('normal')) : '' }}'); background-position: center center;">
        <div class="mask">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-title">
                            <h1 class="text-center text-white text-uppercase">
                                {{ $title }}
                            </h1>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active">Shop List</li>
                        </ol>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="py-5 slice bg-section-secondary">
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
                                        <label class="form-label" for="nom">Nom</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="nom" wire:keydown.enter.prevent="store" class="form-control" id="nom" placeholder="Nom" required />
                                        @error('nom')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="prenoms">Prénoms</label>
                                        <input type="text" wire:model.defer="prenoms" wire:keydown.enter.prevent="store" class="form-control" id="prenoms" placeholder="Prénoms" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="email">Email</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="email" name="email" wire:keydown.enter.prevent="store" class="form-control" id="email" placeholder="Email" required />
                                        @error('email')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1 col-md-6 col-12 position-relative">
                                        <label class="form-label" for="phone">Téléphone</label>
                                        <input type="text" wire:model.defer="phone" wire:keydown.enter.prevent="store" class="form-control" id="phone" placeholder="00 00 00 00 00" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-12 col-12 position-relative">
                                        <label class="form-label" for="sujet">Sujet</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" wire:model.defer="sujet" wire:keydown.enter.prevent="store" class="form-control" id="sujet" placeholder="Sujet" required />
                                        @error('sujet')
                                            <div class="text-center text-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="message">Message</label>
                                            <span class="text-danger">*</span>
                                            <textarea class="form-control" wire:model.defer="message" name="message" id="message" rows="3" placeholder="Votre message..."></textarea>
                                            @error('message')
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
