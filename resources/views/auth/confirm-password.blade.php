<x-guest-layout>
    <x-slot name="title">Confirmation de mot de passe</x-slot>
    @include('composant.header.header-1')
    <div class="bg-absolute-cover bg-size--contain d-none d-lg-block">
        <figure class="w-100">
            <img alt="Image placeholder" src="{{ asset('img/svg/backgrounds/bg-3.svg') }}" class="svg-inject" />
        </figure>
    </div>
    <div class="container mt-6 mb-5">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-lg-6 col-xl-5">
                <div class="card shadow zindex-100 mb-0">
                    <div class="card-body px-md-5 py-5">
                        <div class="mb-4 text-sm text-gray-600">
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </div>

                        <x-jet-validation-errors class="mb-4" />

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div>
                                <x-jet-label for="password" value="{{ __('Password') }}" />
                                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
                            </div>

                            <div class="flex justify-end mt-4">
                                <x-jet-button class="ml-4 btn-warning">
                                    {{ __('Confirmer') }}
                                </x-jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
