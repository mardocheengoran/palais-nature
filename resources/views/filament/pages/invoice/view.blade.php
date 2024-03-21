<x-filament::page class="filament-inoice-view">
    <section class="grid gap-4">
        <div class="py-2">
            <h1 class="text-sm font-bold text-gray-900 lg:text-2xl">
                Cette commande a été passée le {{ \Carbon\Carbon::parse( $record->created_at)->isoFormat('dddd D MMMM YYYY à HH:mm') }}
            </h1>
        </div>
        {{-- @php(dd($record->toArray())) --}}
        <div class="grid w-full gap-4 py-3 rounded-lg lg:flex">
            <div class="lg:w-[66.66%] justify-between bg-white lg:flex py-3">
                <div class="px-4 text-sm lg:text-xl">
                    <h4 class="p-2"> Numero de commande : <span class="font-semibold lg:text-xl"> {{ $record->code }} </span></h4>
                    <h4 class="p-2"> Client :<span class="font-semibold lg:text-xl"> M./Mm  {{ $record->customer->fullname }} </span> </h4>
                    <h4 class="p-2"> Etat : <span class="lg:text-sm text-white py-1.5 px-3 rounded-lg font-semibold bg-{{ $record->state->color}}"> {{ $record->state->title }} </span> </h4>
                    <h4 class="p-2">
                        Groupe sanguin :
                        <span class="lg:text-sm text-white py-1.5 px-3 rounded-lg font-semibold bg-blue-500">
                            {{ $record->content }}
                        </span>
                    </h4>
                    {{-- @php(dd($record->states->toArray())) --}}
                    @isset($record->paymentMethod->title)
                        <h4 class="p-2"> Mode de payement : <span class="font-semibold lg:text-xl"> {{ $record->paymentMethod->title }} </span> </h4>
                    @endisset
                    @isset($record->deliveryMode->title)
                        <h4 class="p-2"> Mode de livraison :  <span class="font-semibold lg:text-xl"> {{ $record->deliveryMode->title }} </span></h4>
                    @endisset
                    @isset($record->address->title)
                        <h4 class="p-2">
                            Adresse de livraison :
                            <span class="font-semibold lg:text-xl">
                                {{ $record->address->title }} |
                                @if ($record->address->city_id == 270)
                                    {{ $record->address->location }}
                                @else
                                    @if ($record->address->country_id == 110)
                                        {{ isset($record->address->city->title) ? $record->address->city->title : '' }} |
                                    @else
                                        {{ isset($record->address->country->title) ? $record->address->country->title : '' }} |
                                    @endif
                                @endif
                                <i class="text-muted">({{ $record->address->subtitle }})</i>
                            </span>
                        </h4>
                    @endisset
                </div>
                <div class="px-4 text-sm lg:text-xl">
                    <h4 class="p-2"> Nombre total d'articles :<span class="font-semibold lg:text-xl"> {{ $record->quantity }} </span> </h4>
                    <h4 class="p-2"> Prix de la livraison : <span class="font-semibold lg:text-xl"> {{ devise($record->price_delivery) }} </span></h4>
                    <h4 class="p-2"> Prix hors-tax : <span class="font-semibold lg:text-xl"> {{ devise($record->price_ht) }} </span> </h4>
                    <h4 class="p-2 font-semibold"> Prix total : {{ devise($record->price_final) }}</h4>
                </div>
            </div>
            <div class="text-sm lg:text-xl px-4 bg-white shadow-lg lg:w-[33.33%]">
                <ol class="relative py-3 border-l border-gray-200 dark:border-gray-700">
                    @foreach ($record->states as $state)
                        <li class="mb-10 ml-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse(  $state->pivot->created_at)->isoFormat('dddd D MMMM YYYY') }}</time>
                            <h3 class="lg:text-sm text-white py-1.5 px-3 rounded-lg font-semibold bg-{{ $state->color }}">{{ $state->title }}</h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400"></p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <div class="relative px-4 overflow-x-auto text-gray-600 bg-white shadow-lg rounded-xl">
            <div class="py-2">
                <h2 class="font-bold lg:text-xl">Les produits de la commande</h2>
            </div>
            <div class="py-3 ">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="">
                            <th scope="col" class="px-6 py-3 text-xs lg:text-xl">
                                Intitulé
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs lg:text-xl">
                               Quantité
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs lg:text-xl">
                               Prix unitaire
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs lg:text-xl">
                               Prix total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->articles as $article )
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                    <div class="flex items-center gap-2">
                                        <div class="">
                                            <img  class="object-cover w-10 h-10 rounded-full lg:w-100 lg:h-100" src="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                                        </div>
                                        <div class="lg:text-xl">
                                            {{ $article->title }}
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4 lg:text-xl">
                                   {{ $article->pivot->quantity }}
                                </td>
                                <td class="px-6 py-4 lg:text-xl">
                                   {{ devise($article->price_new) }}
                                </td>
                                <td class="px-6 py-4 text-green-500 lg:text-xl">
                                    {{ devise($article->pivot->price_total) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-filament::page>
