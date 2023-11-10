<x-filament::page class="filament-project-view">
    <div class="p-2 grid gap-6">
        <div class="rounded-lg shadow-lg bg-white max-w-[100%] ">
            <h1 class="text-center text-cyan-600 group-hover:text-white text-3xl font-semibold px-3 py-3">
                Toutes les informations sur  {{ $record->title }}
            </h1>
            <div class="flex">
                <div  class="px-6 py-3 w-[60%]">
                    <h2 class="text-gray-900 font-bold px-6 py-2"> Projet :
                        <span class="text-cyan-500" >
                            {{ $record->title }}
                        </span>
                    </h2>
                    <h2 class="text-gray-900 font-bold px-6 py-2"> Type Projet :
                        <span class="text-cyan-500" >
                            {{ $record->typeProject->title }}
                        </span>
                    </h2>
                    <h2 class="text-gray-900 font-bold px-6 py-2"> Total participants :
                        <span class="text-cyan-500" >
                           10000
                        </span>
                    </h2>
                </div>
                <div  class="px-6 py-3  w-[40%]">
                    <div class="flex text-gray-900 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="pt-2 text-cyan-500">
                            {{$record->locality->title}}
                        </div>
                    </div>
                    <div class="text-gray-900 font-bold py-2">
                       <h1 class="text"> Date de début :
                            <span class="text-cyan-300 hover:text-gray-500" data-popover-target="date-1" type="button" title="">
                                {{ $record->start_at->diffForHumans() }}
                            </span>
                            <div data-popover id="date-1" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h5 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $record->start_at->isoFormat('dddd D MMMM YYYY') }}
                                    </h5>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                       </h1>
                    </div>
                    <div class="text-gray-900 font-bold py-2">
                        <h1 class="text"> Date de fin :
                            <span class="text-cyan-300 hover:text-gray-500" data-popover-target="dateend-1" type="button">
                                {{ $record->end_at->diffForHumans() }}
                            </span>
                            <div data-popover id="dateend-1" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h5 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $record->end_at->isoFormat('dddd D MMMM YYYY') }}
                                    </h5>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </h1>
                     </div>
                </div>
            </div>

            <div class="rounded-lg bg-white max-w-[100%]">
                <div class="justify-items-center">
                    <div class="px-3 py-2">
                        <h1 class="text-gray-900 text-xl text-center font-bold "> Resumé en image</h1>
                    </div>
                    <!-- Test pour afficher les images -->

                    <div class="flex justify-center">
                        <div  id="gallery" class="relative w-full" data-carousel="slide">
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                @foreach ($record->getMedia('image') as $item)
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        {{-- @php(dd($record->getMedia('image'))) --}}
                                        <img class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"  src="{{ url($item->getUrl('small')) }}" alt="{{ $record->title }}">
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg aria-hidden="true" class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg aria-hidden="true" class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white shadow-lg max-w-[100%] ">
            <h1 class="text-cyan-600 group-hover:text-white text-xl font-semibold px-3 py-3">
               Liste des activités ménées pour {{ $record->title }}
            </h1>

            <div class="items-center justify-between px-4 py-8 grid grid-cols-3 md:grid-cols-3 gap-2">
                @foreach ($record->activities as $activity )
                    <div class="px-6 py-5 border-solid border-2  border-cyan-100 hover:border-none rounded-lg hover:bg-cyan-50">
                        <h2 class="text-gray-900 font-bold"> Activité :
                            <span class="text-cyan-500 p-2" >
                                {{ $activity->title }}
                            </span>
                        </h2>
                        <h2 class="text-gray-900 font-bold"> Type Activité :
                            <span class="text-cyan-500 p-2" >
                                {{ $activity->typeActivity->title }}
                            </span>
                        </h2>
                        <div class="text-gray-900 font-bold py-2">
                            <h1 class="text"> Date de début :
                                <span class="text-cyan-300 hover:text-gray-500" data-popover-target="{{ $activity->id }}" type="button">
                                    {{ $activity->start_at->diffForHumans() }}
                                </span>
                                <div data-popover id="{{ $activity->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h5 class="font-semibold text-gray-900 dark:text-white">{{ $activity->start_at->isoFormat('dddd D MMMM YYYY') }}</h5>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            </h1>
                        </div>
                        <div class="text-gray-900 font-bold py-2">
                            <h1 class="text"> Date de fin :
                                <span class="text-cyan-300 hover:text-gray-500" data-popover-target="{{ $activity->id }}" type="button">
                                    {{ $activity->end_at->diffForHumans() }}
                                </span>
                                <div data-popover id="{{ $activity->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h5 class="font-semibold text-gray-900 dark:text-white">{{ $activity->end_at->isoFormat('dddd D MMMM YYYY') }}</h5>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            </h1>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament::page>
