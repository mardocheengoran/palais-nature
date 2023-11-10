<x-guest-layout>
    <x-slot name="title">Réinitiation de mot de passe</x-slot>
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
                            {{ __('Mot de passe oublié ? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
                        </div>
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        <x-jet-validation-errors class="mb-4" />
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="block">
                                <x-jet-label for="email" value="{{ __('Email') }}" />
                                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <x-jet-button>
                                    {{ __('Réinitialiser') }}
                                </x-jet-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('composant.footer.footer-ecommerce')
    @push('script')
        <script src="{{ asset('assets/libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    @endpush
</x-guest-layout>
