{{-- Aller sur le site web --}}
<div class="filament-breadcrumbs ml-4">
    <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="w-10 h-10 bg-gray-900 bg-center bg-cover rounded-full hover:bg-gray-950" type="button">
        <p class="font-bold text-white px-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </p>
    </button>
    <!-- Dropdown menu -->
    <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
        {{-- <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
            <div class="font-medium">Changer de Projet</div>
        </div> --}}
        <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
            <li>
                <a href="{{ route('welcome') }}" target="_blank" class="block px-4 py-2 rounded hover:bg-orange-200 dark:hover:bg-orange-600 dark:hover:text-white">
                    Aller au site web
                </a>
            </li>
        </ul>
    </div>
</div>



@php
    $user = \Filament\Facades\Filament::auth()->user();
    $items = \Filament\Facades\Filament::getUserMenuItems();

    $accountItem = $items['account'] ?? null;
    $accountItemUrl = $accountItem?->getUrl();

    $logoutItem = $items['logout'] ?? null;
@endphp

{{ \Filament\Facades\Filament::renderHook('user-menu.start') }}

<x-filament::dropdown placement="bottom-end">
    <x-slot name="trigger" class="ml-4 rtl:mr-4 rtl:ml-0">
        <button class="block" aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
            <x-filament::user-avatar :user="$user" />
        </button>
    </x-slot>

    {{ \Filament\Facades\Filament::renderHook('user-menu.account.before') }}

    <x-filament::dropdown.header
        :color="$accountItem?->getColor() ?? 'secondary'"
        :icon="$accountItem?->getIcon() ?? 'heroicon-s-user-circle'"
        :href="$accountItemUrl"
        :tag="filled($accountItemUrl) ? 'a' : 'div'"
    >
        {{ $accountItem?->getLabel() ?? \Filament\Facades\Filament::getUserName($user) }}
    </x-filament::dropdown.header>

    {{ \Filament\Facades\Filament::renderHook('user-menu.account.after') }}

    <x-filament::dropdown.list
        x-data="{
            mode: null,

            theme: null,

            init: function () {
                this.theme = localStorage.getItem('theme') || (this.isSystemDark() ? 'dark' : 'light')
                this.mode = localStorage.getItem('theme') ? 'manual' : 'auto'

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
                    if (this.mode === 'manual') return

                    if (event.matches && (! document.documentElement.classList.contains('dark'))) {
                        this.theme = 'dark'

                        document.documentElement.classList.add('dark')
                    } else if ((! event.matches) && document.documentElement.classList.contains('dark')) {
                        this.theme = 'light'

                        document.documentElement.classList.remove('dark')
                    }
                })

                $watch('theme', () => {
                    if (this.mode === 'auto') return

                    localStorage.setItem('theme', this.theme)

                    if (this.theme === 'dark' && (! document.documentElement.classList.contains('dark'))) {
                        document.documentElement.classList.add('dark')
                    } else if (this.theme === 'light' && document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark')
                    }

                    $dispatch('dark-mode-toggled', this.theme)
                })
            },

            isSystemDark: function () {
                return window.matchMedia('(prefers-color-scheme: dark)').matches
            },
        }"
    >
        <div>
            @if (config('filament.dark_mode'))
                <x-filament::dropdown.list.item icon="heroicon-s-moon" x-show="theme === 'dark'" x-on:click="close(); mode = 'manual'; theme = 'light'">
                    {{ __('filament::layout.buttons.light_mode.label') }}
                </x-filament::dropdown.list.item>

                <x-filament::dropdown.list.item icon="heroicon-s-sun" x-show="theme === 'light'" x-on:click="close(); mode = 'manual'; theme = 'dark'">
                    {{ __('filament::layout.buttons.dark_mode.label') }}
                </x-filament::dropdown.list.item>
            @endif
        </div>

        @foreach ($items as $key => $item)
            @if ($key !== 'account' && $key !== 'logout')
                <x-filament::dropdown.list.item
                    :color="$item->getColor() ?? 'secondary'"
                    :icon="$item->getIcon()"
                    :href="$item->getUrl()"
                    tag="a"
                >
                    {{ $item->getLabel() }}
                </x-filament::dropdown.list.item>
            @endif
        @endforeach

        <x-filament::dropdown.list.item
            :color="$logoutItem?->getColor() ?? 'secondary'"
            :icon="$logoutItem?->getIcon() ?? 'heroicon-s-logout'"
            :action="$logoutItem?->getUrl() ?? route('filament.auth.logout')"
            method="post"
            tag="form"
        >
            {{ $logoutItem?->getLabel() ?? __('filament::layout.buttons.logout.label') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>

{{ \Filament\Facades\Filament::renderHook('user-menu.end') }}
