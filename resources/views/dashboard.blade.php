<x-app-layout>
    <div class="py-24 flex justify-center">
        <div class="max-w-7xl w-full px-4 sm:px-6 lg:px-8">
            <div class="text-gray-900 dark:text-gray-100">

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