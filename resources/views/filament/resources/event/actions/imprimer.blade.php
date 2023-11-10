
    <div class="p-2 grid gap-6">
        <div class="rounded-lg max-w-[100%]">
            <h1 class="text-center text-cyan-600 group-hover:text-white text-3xl font-semibold px-3 py-8">
                Toutes les informations sur la commission {{ $record->title }}
            </h1>

                <button class="">
                    <a href="{{route('imprimer',$record->id)}}">
                        IMPRIMER
                    </a>
                </button>


            <div class="flex gap-4">
                <div class="bg-white shadow-lg rounded-lg px-6 py-3 w-[25%] text-center">
                    <h1 class="text-gray-900 text-xl font-bold">
                        Budget Proposé
                    </h1>
                    <h2 class="text-gray-900 font-bold px-3 py-2">
                        <span class="text-cyan-500 text-xl">
                           {{ devise($record->amount_propose)}}
                        </span>
                    </h2>
                </div>

                <div class="bg-white shadow-lg rounded-lg px-6 py-3 w-[25%] text-center">
                    <h1 class="text-gray-900 text-xl font-bold">
                        Budget Validé
                    </h1>
                    <h2 class="text-gray-900 font-bold px-3 py-2">
                        <span class="text-green-500 text-xl ">
                           {{ devise($record->amount_valid)}}
                        </span>
                    </h2>
                </div>

                <div class="bg-white shadow-lg rounded-lg px-6 py-3 w-[25%] text-center">
                    <h1 class="text-gray-900 text-xl font-bold ">
                       Dépense
                    </h1>
                    <h2 class="text-gray-900 font-bold px-3 py-2">
                        <span class="text-red-500 p-2 text-xl">
                            {{ devise($record->amount_expense)}}
                        </span>
                    </h2>
                </div>

                <div class="bg-white shadow-lg rounded-lg px-6 py-3 w-[25%] text-center">
                    <h1 class="text-gray-900 text-xl font-bold ">
                        Solde
                    </h1>
                    <h2 class="text-gray-900 font-bold px-3 py-2">
                        <span class="text-green-200 p-2 text-xl">
                            {{ devise($record->amount_sold)}}
                        </span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="shadow-lg rounded-lg  bg-white  py-4">
            <h1 class="text-cyan-500 group-hover:text-white text-xl font-semibold px-3 py-3">
               Ligne budgetaire
             </h1>
             <div class="px-4 py-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-t-lg">
                    <thead class="text-xs text-gray-700 uppercase bg-cyan-50 dark:bg-gray-700 dark:text-cyan-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Intitulé
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Montant proposé
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                               Montant validé
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->budgets as $budget )
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{$budget->title}}
                                </td>

                                <td class="px-6 py-4 font-medium text-cyan-500 dark:text-white text-center">
                                    {{$budget->amount_propose}}
                                </td>

                                <td class="px-6 py-4 font-medium text-green-500 dark:text-white text-center">
                                    {{$budget->amount_valid}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
             </div>
        </div>

        <div class="shadow-lg rounded-lg  bg-white  py-4">
            <h1 class="text-cyan-500 group-hover:text-white text-xl font-semibold px-3 py-3">
                Liste des membres la commission
             </h1>
             <div class="px-4 py-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-t-lg">
                    <thead class="text-xs text-gray-700 uppercase bg-cyan-50 dark:bg-gray-700 dark:text-cyan-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Nom
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Prénom
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Poste
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->users as $user )
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{$user->last_name}}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{$user->first_name}}
                                </td>

                                <td class="px-6 py-4 font-medium text-red-500 dark:text-white">
                                    {{$user->pivot->occupation}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
             </div>
        </div>

        <div class="rounded-lg bg-white shadow-lg max-w-[100%] ">
            <h1 class="text-cyan-500 group-hover:text-white text-xl font-semibold px-3 py-3">
               Liste des tâches a effectuer pour la commission {{ $record->title }}
            </h1>
            <div class="items-center justify-between px-4 py-8 grid grid-cols-3 md:grid-cols-3 gap-2">
                @foreach ($record->tasks as $task )
                    <div class="px-6 py-5 border-solid border-2  border-cyan-100 hover:border-none  rounded-lg hover:bg-cyan-50">
                        <h2 class="text-gray-900 font-bold"> Intitulé :
                            <span class="text-cyan-500 p-2" >
                                {{ $task->title }}
                            </span>
                        </h2>
                        <div class="text-gray-900 font-bold py-2">
                            <h1 class="text"> Date de début :
                                <span class="text-cyan-300 hover:text-gray-500" data-popover-target="{{ $task->id }}" type="button">
                                    {{ $task->start_at->diffForHumans() }}
                                </span>
                                <div data-popover id="{{ $task->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h5 class="font-semibold text-gray-900 dark:text-white">{{ $task->start_at->isoFormat('dddd D MMMM YYYY') }}</h5>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            </h1>
                        </div>
                        <div class="text-gray-900 font-bold py-2">
                            <h1 class="text"> Date de fin :
                                <span class="text-cyan-300 hover:text-gray-500" data-popover-target="{{ $task->id }}" type="button">
                                    {{ $task->end_at->diffForHumans() }}
                                </span>
                                <div data-popover id="{{ $task->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h5 class="font-semibold text-gray-900 dark:text-white">{{ $task->end_at->isoFormat('dddd D MMMM YYYY') }}</h5>
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

