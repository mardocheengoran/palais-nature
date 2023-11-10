<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profil Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Mettez à jour les informations de profil') }}
    </x-slot>

    <x-slot name="form">

        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Sauvegardé.') }}
        </x-jet-action-message>
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="object-cover w-20 h-20 rounded-full">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Nom') }}" />
            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Prénoms -->
        <div class="mb-2">
            <x-jet-label for="first_name" value="{{ __('Prénoms') }}" />
            <x-jet-input id="first_name" type="text" class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}" wire:model.defer="state.first_name" autocomplete="first_name" />
            <x-jet-input-error for="first_name" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="block w-full mt-1" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="mt-2 text-sm">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="text-sm text-gray-600 underline hover:text-gray-900" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 text-sm font-medium text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="mb-2">
            <x-jet-label for="phone" value="{{ __('Numéro téléphone') }}" />
            <x-jet-input id="phone" data-mask="00 00 00 00 00" placeholder="00 00 00 00 00" type="text" class="{{ $errors->has('phone') ? 'is-invalid' : '' }} input-mask" wire:model.defer="state.phone" />
            <x-jet-input-error for="phone" />
        </div>

        <!-- Sexe -->
        <div class="mb-2">
            <x-jet-label for="sex" value="{{ __('Sexe') }}" />
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" wire:model.defer="state.sex" name="sex" id="inlineRadio3" value="Masculin" />
                    <label class="form-check-label" for="inlineRadio3">Masculin</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" wire:model.defer="state.sex" name="sex" id="inlineRadio4" value="Féminin" />
                    <label class="form-check-label" for="inlineRadio4">Féminin</label>
                </div>
            </div>
            <x-jet-input-error for="sex" />
        </div>

        <!-- Image -->
        <div class="mb-2">
            @if(count(auth()->user()->getMedia('image')))
                <img alt="{{ auth()->user()->fullname }}" src="{{ url(auth()->user()->getFirstMediaUrl('image', 'thumb')) }}" style="width: 40px; float: right;" class="round">
            @endif
            <x-jet-label for="image" value="{{ __('Votre photo') }}" />
            <x-jet-input id="image" type="file" class="{{ $errors->has('image') ? 'is-invalid' : '' }}" wire:model.defer="state.image" name="image" />
            <x-jet-input-error for="image" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button wire:loading.attr="disabled" wire:target="photo" class="btn-warning">
            {{ __('Enregistrer') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
