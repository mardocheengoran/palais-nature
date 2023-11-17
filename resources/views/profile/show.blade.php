<div>
    @include('layouts.header')
    <!-- Page Title-->
    <div class="page-title-overlap bg-primary pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('welcome') }}"><i class="ci-home"></i>Accueil</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap"><a href="{{ route('profil.index') }}">Compte</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">{{ $title }}</h1>
            </div>
        </div>
    </div>

    <div class="container pb-5 mb-2 mb-md-3">
        <div class="row">
            @include('livewire.profil.account')
            <!-- Content  -->
            <div class="mt-5 col-lg-9 order-lg-1 order-0">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                    <span id="update-password"></span>
                    <x-jet-section-border />
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>

                    <x-jet-section-border />
                @endif

                {{-- @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.two-factor-authentication-form')
                    </div>

                    <x-jet-section-border />
                @endif --}}

                {{-- <div class="mt-10 sm:mt-0">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div> --}}

                {{-- @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <x-jet-section-border />
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.qenium.com/asset/libs/sticky-kit/dist/sticky-kit.min.js"></script>
        <script src="https://cdn.qenium.com/asset/libs/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    @endpush
</div>
