<div
    x-data="{
        openTab : 1,
        activeClasses: 'border-l border-t border-r rounded-t texte-cyan-500',
        inactiveClasses: 'text-red-500 hover:text-red-700'
    }"
    >
    <ul class="flex border-b">
        <li @click="openTab = 1" :class="{'-mb-px': openTab === 1}" class="mr-1">
            <a :class="openTab === 1 ? activeClasses : inactiveClasses" href="#" class="inline-block py-2 px-4 font-semibold">
                Ligne budgétaire
            </a>
        </li>
        <li @click="openTab = 2" :class="{'-mb-px': openTab === 2}" class="mr-1">
            <a :class="openTab === 2 ? activeClasses : inactiveClasses" href="#" class="inline-block py-2 px-4 font-semibold">
                Membres
            </a>
        </li>
        <li @click="openTab = 3" :class="{'-mb-px': openTab === 3}" class="mr-1">
            <a :class="openTab === 3 ? activeClasses : inactiveClasses" href="#" class="inline-block py-2 px-4 font-semibold">
                Tâches
            </a>
        </li>
        <li @click="openTab = 4" :class="{'-mb-px': openTab === 4}" class="mr-1">
            <a :class="openTab === 4 ? activeClasses : inactiveClasses" href="#" class="inline-block py-2 px-4 font-semibold">
                Dépenses
            </a>
        </li>
    </ul>
    <div>
        <div class="shadow-lg rounded-lg  bg-white  py-4">
            <div x-show ="openTab === 1" class="px-4 py-4">
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
            <div x-show ="openTab === 2" class="px-4 py-4">
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
            <div x-show ="openTab === 3" class="px-4 py-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-t-lg">
                    <thead class="text-xs text-gray-700 uppercase bg-cyan-50 dark:bg-gray-700 dark:text-cyan-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Intitulé
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date de début
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Date de fin
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->tasks as $task )
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $task->title }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <span class="text-gray-800 hover:text-gray-500" data-popover-target="{{ $task->id }}" type="button">
                                        {{ $task->start_at->diffForHumans() }}
                                    </span>
                                    <div data-popover id="{{ $task->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                        <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                            <h5 class="font-semibold text-gray-900 dark:text-white">{{ $task->start_at->isoFormat('dddd D MMMM YYYY') }}</h5>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-medium text-red-500 dark:text-white">
                                    <span class="text-gray-800 hover:text-gray-500" data-popover-target="{{ $task->id }}" type="button">
                                        {{ $task->end_at->diffForHumans() }}
                                    </span>
                                    <div data-popover id="{{ $task->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                        <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                            <h5 class="font-semibold text-gray-900 dark:text-white">{{ $task->end_at->isoFormat('dddd D MMMM YYYY') }}</h5>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div x-show ="openTab === 4" class="px-4 py-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 rounded-t-lg">
                    <thead class="text-xs text-gray-700 uppercase bg-cyan-50 dark:bg-gray-700 dark:text-cyan-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Intitulé
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Montant
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->expenses as $expense )
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $expense->title }}
                                </td>

                                <td class="px-6 py-4 font-medium text-red-500 dark:text-white">
                                    {{ $expense->amount_final }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


