<div>
    <!-- Table 1 -->
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full">
            <div class="flex ">
                <div class="max-w-lg w-full lg:max-w-xs">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="mt-2 h-5 w-5 gray" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input wire:model="searchInputDay"
                            wire:input="searchTableDaily"
                            id="searchInputDay"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out"
                            placeholder="Buscar tareas hoy" type="search">
                    </div>
                </div>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <caption class="font-large font-bold">Tareas de hoy</caption>
                    <thead>
                        <tr class="text-center">
                            <th class="px-6 py-3 bg-gray-50  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('name')" class="hover:bg-transparent">
                                    Tarea
                                </button>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('name')" class="hover:bg-transparent">
                                    Descripcion
                                </button>                                
                            </th>
                            <th class="px-6 py-3 bg-gray-50  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Inicio (AA/mm/dd)
                            </th>
                            <th class="px-6 py-3 bg-gray-50  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Fin (AA/mm/dd)
                            </th>
                            <th class="px-6 py-3 bg-gray-50  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Proxima Fecha A ejecutarse (AA/mm/dd)
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Frecuencia
                            </th>
                            <th class="px-6 py-3 bg-gray-50">Tarea realizada?</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($allTaskDay as $task)
                        <tr>
                            <td class="px-10 py-4 w-1/10 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                        {{ $task->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="w-1/4 px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $task->description }} </div>
                            </td>
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $task->ini_date }} </div>
                            </td>
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $task->fin_date }} </div>
                            </td>
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $task->next_date }} </div>
                            </td>
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $task->frequency }} </div>
                            </td>                            
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <div>
                                    <input type="checkbox" wire:model="registerTasksCompleted.{{ $task->id }}"
                                            id="checkbox_{{ $task->id }}" 
                                            wire:change="taskCompleted({{ $task->id }})" 
                                            wire:loading.attr="disabled"
                                            @if(!empty($registerTasksCompleted) && isset($registerTasksCompleted[$task->id]) && $registerTasksCompleted[$task->id])
                                                disabled
                                            @endif>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                @if ($allTaskDay->hasPages())
                    <div class="text-center">
                        <nav role="navigation" aria-label="Pagination Navigation">
                            <span>
                                @if ($allTaskDay->onFirstPage())
                                    <span>Previous</span>
                                @else
                                    <button class="px-4 py-1 text-sm font-semibold border border-purple-200 hover:text-white hover:bg-purple-600" wire:click="previousPage('task-today')" wire:loading.attr="disabled" rel="prev"><< Previous</button>
                                @endif
                            </span>
                
                            <span>
                                @if ($allTaskDay->onLastPage())
                                    <span>Next</span>
                                @else
                                    <button class="px-4 py-1 text-sm font-semibold border border-purple-200 hover:text-white hover:bg-purple-600" wire:click="nextPage('task-today')" wire:loading.attr="disabled" rel="next">Next >></button>
                                @endif
                            </span>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <br>
    <hr>
    <hr>
    <br>
    <!-- Table 2 -->
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full">
            <div class="flex ">
                <div class="max-w-lg w-full lg:max-w-xs">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="mt-2 h-5 w-5 gray" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input wire:model="searchInputWeek"
                            wire:input="searchTableWeek"
                            id="searchInputWeek"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out"
                            placeholder="Buscar" type="search">
                    </div>
                </div>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <caption class="font-large font-bold">Tareas para la semana</caption>
                    <thead>
                        <tr class="text-center">
                            <th class="px-6 py-3 bg-gray-50  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Tarea
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Descripcion
                            </th>
                            <th class="px-6 py-3 bg-gray-50  text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Proxima Fecha A ejecutarse (AA/mm/dd)
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Frecuencia
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($allTaskWeek as $task)
                        <tr>
                            <td class="px-10 py-4 w-1/10 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                        {{ $task->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="w-1/4 px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{ $task->description }} </div>
                            </td>
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap">
                                <div class="text-center text-sm leading-5 text-gray-900">{{ $task->next_date }} </div>
                            </td>
                            <td class="w-1/15 px-6 py-4 whitespace-no-wrap">
                                <div class="text-center text-sm leading-5 text-gray-900">{{ $task->frequency }} </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                @if ($allTaskWeek->hasPages())
                    <div class="text-center">
                        <nav role="navigation" aria-label="Pagination Navigation">
                            <span>
                                @if ($allTaskWeek->onFirstPage())
                                    <span>Previous</span>
                                @else
                                    <button class="px-4 py-1 text-sm font-semibold border border-purple-200 hover:text-white hover:bg-purple-600" wire:click="previousPage('task-week')" wire:loading.attr="disabled" rel="prev"><< Previous</button>
                                @endif
                            </span>
                
                            <span>
                                @if ($allTaskWeek->onLastPage())
                                    <span>Next</span>
                                @else
                                    <button class="px-4 py-1 text-sm font-semibold border border-purple-200 hover:text-white hover:bg-purple-600" wire:click="nextPage('task-week')" wire:loading.attr="disabled" rel="next">Next >></button>
                                @endif
                            </span>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
