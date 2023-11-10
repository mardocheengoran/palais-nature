<div>
    <x-slot name="title">Modifier profil</x-slot>
    @include('layouts.header')

    <div class="container pb-5 mb-2 mb-md-3">
        <div class="row">
            @include('livewire.profil.account')
            <!-- Content  -->
            <div class="mt-5 col-lg-8 order-lg-1 order-0">
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
