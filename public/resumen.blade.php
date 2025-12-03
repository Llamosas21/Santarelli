<x-app-layout>
    <div class="py-24 flex justify-center">
        <div x-data="{ view: 'table' }" class="max-w-7xl w-full px-4 sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100">

                <div class="mb-8 flex flex-col sm:flex-row justify-between sm:items-center gap-4 px-4">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        Resumen del mes
                    </h2>
                    <div class="flex items-center justify-between sm:justify-end gap-4">
                        <div class="flex space-x-1 bg-gray-200 dark:bg-gray-700 p-0.5 rounded-lg">
                            <button @click="view = 'table'"
                                :class="view === 'table' ? 'bg-white dark:bg-gray-900 text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="p-1.5 rounded-md transition-colors" title="Vista de Tabla">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                            </button>
                            <button @click="view = 'cards'"
                                :class="view === 'cards' ? 'bg-white dark:bg-gray-900 text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="p-1.5 rounded-md transition-colors" title="Vista de Cards">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                            </button>
                        </div>

                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                                    Filtro
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                <div class="p-4">
                                    <form action="{{ route('resumen') }}" method="GET" class="space-y-4">
                                        <div>
                                            <label for="estado_filtro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado:</label>
                                            <select name="estado" id="estado_filtro" class="mt-1 block w-full py-2 pl-3 pr-10 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm cursor-pointer">
                                                <option value="pendiente" @if($estadoFiltro === 'pendiente') selected @endif>Pendientes</option>
                                                <option value="aceptado" @if($estadoFiltro === 'aceptado') selected @endif>Aceptadas</option>
                                                <option value="rechazado" @if($estadoFiltro === 'rechazado') selected @endif>Rechazadas</option>
                                                <option value="todos" @if($estadoFiltro === 'todos') selected @endif>Todas</option>
                                            </select>
                                        </div>
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-2">
                                            <button type="submit" class="w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Aplicar Filtro</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($reservas->isEmpty())
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        No hay reservas que coincidan con los filtros seleccionados.
                    </div>
                @else

                    <div x-show="view === 'table'" x-transition
                         class="bg-white dark:bg-slate-900/70 rounded-2xl p-4 shadow-sm border border-gray-200 dark:border-transparent">
                        <div class="overflow-x-auto rounded-lg">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                                        <th scope="col" class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Destino</th>
                                        <th scope="col" class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Fecha Salida</th>
                                        <th scope="col" class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Micros</th>
                                        <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Monto</th>
                                        <th scope="col" class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                        <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($reservas as $reserva)
                                        <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 dark:text-gray-300">{{ $reserva->cliente->nombre ?? '' }} {{ $reserva->cliente->apellido ?? '' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $reserva->lugar->nombre ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ optional($reserva->horario)->fecha_salida ? \Carbon\Carbon::parse($reserva->horario->fecha_salida)->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-center text-gray-700 dark:text-gray-300">{{ $reserva->micros->sum('cantidad') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right text-gray-700 dark:text-gray-300">${{ number_format($reserva->monto, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($reserva->estado === 'aceptado') bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-100
                                                    @elseif($reserva->estado === 'pendiente') bg-orange-100 text-orange-800 dark:bg-orange-500 dark:text-orange-100
                                                    @elseif($reserva->estado === 'rechazado') bg-red-100 text-red-800 dark:bg-red-600 dark:text-red-100
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @endif">
                                                    {{ ucfirst($reserva->estado) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                                @if ($reserva->cliente ?? false)
                                                <div class="flex justify-end gap-3">
                                                    <a href="{{ route('clientes.show', $reserva->cliente->id) }}" class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white transition-colors" title="Ver">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                                    </a>
                                                    <a href="{{ route('reservas.edit', $reserva->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors" title="Editar Reserva">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                                                    </a>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="view === 'cards'" x-transition class="flex flex-wrap justify-center gap-8">
                        @foreach ($reservas as $reserva)
                            <div class="bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 max-w-xs w-full text-center">
                                <div class="mb-3">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $reserva->cliente->nombre ?? '' }} {{ $reserva->cliente->apellido ?? '' }}</h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-300">{{ $reserva->lugar->nombre ?? 'Destino no especificado' }}</p>
                                </div>
                                <div class="space-y-1 text-sm text-gray-700 dark:text-gray-200">
                                    <p><span class="font-semibold">Fecha de Salida:</span> {{ optional($reserva->horario)->fecha_salida ? \Carbon\Carbon::parse($reserva->horario->fecha_salida)->format('d/m/Y H:i') : 'N/A' }}</p>
                                    @if ($reserva->micros->isNotEmpty())
                                        <p><span class="font-semibold">Cantidad Micros:</span> {{ $reserva->micros->sum('cantidad') }}</p>
                                    @endif
                                    <p><span class="font-semibold">Monto:</span> ${{ number_format($reserva->monto, 0, ',', '.') }}</p>
                                    <p><span class="font-semibold">Estado:</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($reserva->estado === 'aceptado') bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-100
                                            @elseif($reserva->estado === 'pendiente') bg-orange-100 text-orange-800 dark:bg-orange-500 dark:text-orange-100
                                            @elseif($reserva->estado === 'rechazado') bg-red-100 text-red-800 dark:bg-red-600 dark:text-red-100
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @endif">
                                            {{ ucfirst($reserva->estado) }}
                                        </span>
                                    </p>
                                </div>
                                @if ($reserva->cliente ?? false)
                                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 mt-4">
                                        <div class="flex w-full items-center gap-3">
                                            <a href="{{ route('clientes.show', $reserva->cliente->id) }}" class="flex-1 text-center rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">Ver</a>
                                            <a href="{{ route('reservas.edit', $reserva->id) }}" class="flex-1 text-center rounded-lg px-4 py-2 text-sm font-semibold text-indigo-600 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">Editar</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
