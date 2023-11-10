@props([
    'breadcrumbs' => [],
])

<div {{ $attributes->class(['filament-breadcrumbs flex-1']) }}>
    <ul @class([
        'hidden gap-4 items-center font-medium text-sm lg:flex',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
        @foreach ($breadcrumbs as $url => $label)
            <li>
                <a
                    href="{{ is_int($url) ? '#' : $url }}"
                    @class([
                        'text-gray-500' => $loop->last && (! $loop->first),
                        'dark:text-gray-300' => ((! $loop->last) || $loop->first) && config('filament.dark_mode'),
                        'dark:text-gray-400' => $loop->last && (! $loop->first) && config('filament.dark_mode'),
                    ])
                >
                    {{ $label }}
                </a>
            </li>

            @if (! $loop->last)
                <li @class([
                    'h-6 border-r border-gray-300 -skew-x-12',
                    'dark:border-gray-500' => config('filament.dark_mode'),
                ])></li>
            @endif
        @endforeach
    </ul>
</div>

@if (auth()->user()->store)
    <div class="flex-1 filament-breadcrumbs">
        <button {{-- id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" --}} data-dropdown-trigger="hover" class="w-60 h-10 bg-gray-900 bg-center bg-cover rounded-full hover:bg-gray-950" type="button">
            <p class="font-bold text-white">
                Boutique : {{ auth()->user()->store }}
            </p>
        </button>
        <!-- Dropdown menu -->
        {{-- <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                <div class="font-medium">Changer de Projet</div>
            </div>
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-green-100 dark:hover:bg-green-600 dark:hover:text-white">Projet 2</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-green-100 dark:hover:bg-green-600 dark:hover:text-white">Projet 3</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-green-100 dark:hover:bg-green-600 dark:hover:text-white">Projet 4</a>
                </li>
            </ul>
        </div> --}}
    </div>
@endif
