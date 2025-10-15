<x-app-layout>
    <div class="py-24 flex justify-center">
        <div class="max-w-7xl w-full px-4 sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100">

                <!-- Filtro -->
                <div class="mb-8 flex justify-between items-center px-4">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        Resumen del mes
                    </h2>

                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <div>
                            <button @click="open = !open" type="button"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                                Filtro
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown filtros -->
                        <div x-show="open" @click.away="open = false" x-transition
                            class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                            <div class="p-4">
                                <form action="{{ route('resumen') }}" method="GET" class="space-y-4">
                                    <div>
                                        <label for="estado_filtro"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Estado:
                                        </label>
                                        <select name="estado" id="estado_filtro"
                                            class="mt-1 block w-full py-2 pl-3 pr-10 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm cursor-pointer">
                                            <option value="pendiente" @if($estadoFiltro === 'pendiente') selected @endif>Pendientes</option>
                                            <option value="aceptado" @if($estadoFiltro === 'aceptado') selected @endif>Aceptadas</option>
                                            <option value="rechazado" @if($estadoFiltro === 'rechazado') selected @endif>Rechazadas</option>
                                            <option value="todos" @if($estadoFiltro === 'todos') selected @endif>Todas</option>
                                        </select>
                                    </div>

                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-2">
                                        <button type="submit"
                                            class="w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Aplicar Filtro
                                        </button>
                                        <!-- // Se deja para futuras modificaciones
                                        <a href="{{ route('resumen') }}"
                                            class="block w-full text-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Limpiar Filtros
                                         -->
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido principal -->
                @if ($reservas->isEmpty())
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        No hay reservas que coincidan con los filtros seleccionados.
                    </div>
                @else
                    <div class="flex flex-wrap justify-center gap-8">
                        @foreach ($reservas as $reserva)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 max-w-xs w-full text-center">

                                <!-- Cliente y destino -->
                                <div class="mb-3">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                        {{ $reserva->cliente->nombre ?? '' }} {{ $reserva->cliente->apellido ?? '' }}
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-300">
                                        {{ $reserva->lugar->nombre ?? 'Destino no especificado' }}
                                    </p>
                                </div>

                                <!-- Datos de la reserva -->
                                <div class="space-y-1 text-sm text-gray-700 dark:text-gray-200">
                                    <p><span class="font-semibold">Fecha de Salida:</span>
                                        {{ optional($reserva->horario)->fecha_salida ? \Carbon\Carbon::parse($reserva->horario->fecha_salida)->format('d/m/Y H:i') : 'N/A' }}
                                    </p>

                                    @if ($reserva->micros->isNotEmpty())
                                        <!-- // Se comenta debido a que pueden haber muchos tipos de micros lo que afecta el que se entienda de primera mano
                                            <p><span class="font-semibold">Tipo Micro:</span>
                                            </p>
                                            -->
                                        <p><span class="font-semibold">Cantidad Micros:</span>
                                            {{ $reserva->micros->sum('cantidad') }}
                                        </p>
                                    @endif

                                    <p><span class="font-semibold">Monto:</span>
                                        ${{ number_format($reserva->monto, 0, ',', '.') }}
                                    </p>

                                    <p><span class="font-semibold">Estado:</span>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($reserva->estado === 'aceptado') bg-green-200 text-green-800 dark:bg-green-600 dark:text-green-100
                                            @elseif($reserva->estado === 'pendiente') bg-orange-200 text-orange-800 dark:bg-orange-500 dark:text-orange-100
                                            @elseif($reserva->estado === 'rechazado') bg-red-200 text-red-800 dark:bg-red-600 dark:text-red-100
                                            @else bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-100 @endif">
                                            {{ ucfirst($reserva->estado) }}
                                        </span>
                                    </p>
                                </div>

                                <!-- Enlaces -->
                                @if ($reserva->cliente ?? false)
                                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 mt-4 flex flex-col items-center gap-3">
    
                                        <a href="{{ route('clientes.show', $reserva->cliente->id) }}" class="inline-flex items-center px-10 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            Ver Cliente
                                        </a>   
                                        <a href="{{ route('reservas.edit', $reserva->id) }}" class="inline-flex items-center px-10 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                            Editar Reserva
                                        </a>

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
