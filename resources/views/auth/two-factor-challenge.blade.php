<x-guest-layout>
    <x-slot name="title">Double vérification</x-slot>
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
                        <div x-data="{ recovery: false }">
                            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                            </div>

                            <div class="mb-4 text-sm text-gray-600" x-show="recovery">
                                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                            </div>

                            <x-jet-validation-errors class="mb-4" />

                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf

                                <div class="mt-4" x-show="! recovery">
                                    <x-jet-label for="code" value="{{ __('Code') }}" />
                                    <x-jet-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                                </div>

                                <div class="mt-4" x-show="recovery">
                                    <x-jet-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                                    <x-jet-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                                    x-show="! recovery"
                                                    x-on:click="
                                                        recovery = true;
                                                        $nextTick(() => { $refs.recovery_code.focus() })
                                                    ">
                                        {{ __('Use a recovery code') }}
                                    </button>

                                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                                    x-show="recovery"
                                                    x-on:click="
                                                        recovery = false;
                                                        $nextTick(() => { $refs.code.focus() })
                                                    ">
                                        {{ __('Use an authentication code') }}
                                    </button>

                                    <x-jet-button class="ml-4">
                                        {{ __('Log in') }}
                                    </x-jet-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
