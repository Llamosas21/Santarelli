<x-app-layout>
    <div class="py-24 flex justify-center">
        <div class="max-w-7xl w-full px-4 sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100">
                 {{-- Filtro --}}
                <div class="mb-8 flex justify-center">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                        
                        {{-- Etiqueta Visible y Estilizada --}}
                        <label for="estado_filtro" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Filtrar:
                        </label>
                        
                        {{-- Selector de Opciones Estilizado --}}
                        <select name="estado" id="estado_filtro" onchange="this.form.submit()"
                            class="py-2 pl-3 pr-10 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-gray-200 
                                rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm appearance-none
                                transition duration-150 ease-in-out cursor-pointer">
                            
                            <option value="pendiente" @if($estadoFiltro === 'pendiente') selected @endif>Pendientes</option>
                            <option value="aceptado" @if($estadoFiltro === 'aceptado') selected @endif>Aceptadas</option>                   
                            <option value="rechazado" @if($estadoFiltro === 'rechazado') selected @endif>Rechazadas</option>
                            <option value="todos" @if($estadoFiltro === 'todos') selected @endif>Todas</option>

                        </select>
                    </form>
                </div>
                @if ($reservas->isEmpty())
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        No hay reservas registradas.
                    </div>
                @else
                    <div class="flex flex-wrap justify-center gap-8">
                        @foreach ($reservas as $reserva)
                            <div class="bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition 
                                        rounded-2xl border border-gray-200 dark:border-gray-700 
                                        p-4 sm:p-6 max-w-xs w-full text-center">
                                
                                {{-- Bloque de texto aclarado --}}
                                <div class="mb-3 dark:!text-gray-200">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:!text-gray-100">
                                        {{ $reserva->cliente->nombre ?? '' }} {{ $reserva->cliente->apellido ?? '' }}
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:!text-gray-300">
                                        {{ $reserva->lugar->nombre ?? 'Destino no especificado' }}
                                    </p>
                                </div>

                                {{-- Datos de la reserva --}}
                                <div class="space-y-1 text-sm dark:!text-gray-200">
                                    <p>
                                        <span class="font-semibold">Tipo Micro:</span>
                                        @foreach ($reserva->micros as $micro)
                                            {{ $micro->tipoMicro->nombre }}
                                            @if (!$loop->last), @endif
                                        @endforeach
                                    </p>

                                    <p>
                                        <span class="font-semibold">Cantidad Micros:</span>
                                        {{ $reserva->micros->sum('cantidad') }}
                                    </p>

                                    <p>
                                        <span class="font-semibold">Monto:</span>
                                        ${{ number_format($reserva->monto, 0, ',', '.') }}
                                    </p>

                                    <p>
                                        <span class="font-semibold">Estado:</span>
                                        <span class="
                                            px-2 py-1 rounded-full text-xs font-semibold
                                            @if($reserva->estado === 'aceptado')
                                                bg-green-200 text-green-800 dark:bg-green-600 dark:text-green-100
                                            @elseif($reserva->estado === 'pendiente')
                                                dark:bg-orange-500 dark:text-orange-100
                                            @elseif($reserva->estado === 'rechazado')
                                                bg-red-200 text-red-800 dark:bg-red-600 dark:text-red-100
                                            @else
                                                bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-100
                                            @endif">
                                            {{ ucfirst($reserva->estado) }}
                                        </span>
                                    </p>
                                </div> {{-- FIN de Datos de la reserva --}}
                                
                                {{-- BLOQUE DE ENLACE REUBICADO AQUÍ --}}
                                @if ($reserva->cliente ?? false)
                                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700 mt-4">
                                        <a href="{{ route('clientes.show', $reserva->cliente->id) }}" 
                                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                                            Ver detalles del Cliente
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