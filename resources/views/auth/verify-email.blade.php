<x-guest-layout>
    <x-slot name="title">Vérifier Email</x-slot>
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
                            {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </div>
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                            </div>
                        @endif

                        <div class="mt-4 flex items-center justify-between">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf

                                <div>
                                    <x-jet-button type="submit">
                                        {{ __('Resend Verification Email') }}
                                    </x-jet-button>
                                </div>
                            </form>

                            <div>
                                <a
                                    href="{{ route('profile.show') }}"
                                    class="underline text-sm text-gray-600 hover:text-gray-900"
                                >
                                    {{ __('Edit Profile') }}</a>

                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf

                                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
