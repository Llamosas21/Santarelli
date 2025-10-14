<x-app-layout>
    <div class="py-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6 px-4 sm:px-0">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Resumen del mes
                </h2>

                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                        Filtro
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                        <div class="p-4">
                            <form action="{{ route('resumen') }}" method="GET" class="space-y-4">
                                <div>
                                    <label for="estado_filtro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado:</label>
                                    
                                    <select name="estado" id="estado_filtro" class="mt-1 block w-full rounded-lg border-gray-300 bg-white text-sm shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="todos" @selected($estadoFiltro === 'todos')>Todas</option>
                                        <option value="pendiente" @selected($estadoFiltro === 'pendiente')>Pendientes</option>
                                        <option value="aceptado" @selected($estadoFiltro === 'aceptado')>Aceptadas</option>
                                        <option value="rechazado" @selected($estadoFiltro === 'rechazado')>Rechazadas</option>
                                    </select>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-2">
                                    <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Aplicar Filtro
                                    </button>
                                    <a href="{{ route('resumen') }}" class="block w-full text-center text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                                        Limpiar Filtro
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        @if ($reservas->isEmpty())
                            <div class="text-center py-12">
                                <p class="text-gray-500 dark:text-gray-400">No se encontraron reservas con ese estado.</p>
                            </div>
                        @else
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Cliente</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Destino</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Fecha de Salida</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Monto</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                    @foreach ($reservas as $reserva)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $reserva->cliente->nombre ?? '' }} {{ $reserva->cliente->apellido ?? '' }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $reserva->lugar->nombre ?? 'N/A' }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ optional($reserva->horario)->fecha_salida ? \Carbon\Carbon::parse($reserva->horario->fecha_salida)->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">${{ number_format($reserva->monto, 0, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                <span @class(['inline-flex rounded-full px-2 text-xs font-semibold leading-5', 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' => $reserva->estado === 'aceptado', 'bg-orange-100 text-orange-800 dark:bg-orange-600 dark:text-orange-100' => $reserva->estado === 'pendiente', 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' => $reserva->estado === 'rechazado'])>
                                                    {{ ucfirst($reserva->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>