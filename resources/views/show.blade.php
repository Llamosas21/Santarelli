<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12 sm:pb-16">

        <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-gray-900 dark:text-gray-100 text-center sm:text-left">
            Detalles de {{ $cliente->nombre }} {{ $cliente->apellido }}
        </h2>

        <!-- Contactos -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-5 sm:p-6 mb-8 border border-indigo-200 dark:border-gray-700 hover:shadow-2xl transition duration-300">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h4 class="font-semibold text-lg mb-3 text-indigo-700 dark:text-indigo-400">Contactos</h4>
                @if($cliente->contactos->isNotEmpty())
                    @foreach($cliente->contactos as $contacto)
                        <p class="text-gray-600 dark:text-gray-300 break-words"><span class="font-semibold">Teléfono:</span> {{ $contacto->telefono ?? 'No registrado' }}</p>
                        <p class="text-gray-600 dark:text-gray-300 break-words"><span class="font-semibold">Email:</span> {{ $contacto->email ?? 'No registrado' }}</p>
                    @endforeach
                @else
                    <p class="text-gray-500 italic bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">No tiene contactos registrados.</p>
                @endif
            </div>
        </div>

        <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Reservas</h3>

        @forelse($cliente->reservas as $reserva)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 sm:p-6 mb-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4">
                    <!-- Resumen -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-lg mb-2 text-indigo-700 dark:text-indigo-400">Resumen</h4>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Lugar destino:</span> {{ $reserva->lugar->nombre ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Cantidad de pasajeros:</span> {{ $reserva->cantidad_pasajeros ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Precio total:</span> ${{ number_format($reserva->monto, 2) }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Estado:</span> 
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($reserva->estado=='pendiente') bg-orange-200 text-orange-800 dark:bg-orange-500 dark:text-orange-100 
                                @elseif($reserva->estado=='aceptado') bg-green-200 text-green-800 dark:bg-green-600 dark:text-green-100
                                @else bg-red-200 text-red-800 dark:bg-red-600 dark:text-red-100 @endif">
                                {{ ucfirst($reserva->estado) }}
                            </span>
                        </p>
                    </div>

                    <!-- Horarios -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-lg mb-2 text-indigo-700 dark:text-indigo-400">Horarios</h4>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Fecha salida:</span> {{ optional($reserva->horario)->fecha_salida ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Fecha regreso:</span> {{ optional($reserva->horario)->fecha_regreso ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Lugar de salida:</span> {{ $reserva->lugar->direccion ?? '-' }}</p>
                    </div>
                </div>

                <!-- Micros -->
                <div class="mt-4 overflow-x-auto">
                    <h4 class="font-semibold mb-2 text-gray-700 dark:text-gray-200">Micros</h4>
                    @if($reserva->micros->isEmpty())
                        <p class="text-gray-500 italic bg-gray-50 dark:bg-gray-700 p-2 rounded text-sm">No hay micros asignados.</p>
                    @else
                        <table class="min-w-full border-collapse border border-indigo-500 dark:border-indigo-400 rounded-lg overflow-hidden text-gray-700 dark:text-gray-200 text-sm sm:text-base">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border border-indigo-500 dark:border-indigo-400 p-2 text-left">Tipo de micro</th>
                                    <th class="border border-indigo-500 dark:border-indigo-400 p-2 text-left">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reserva->micros as $micro)
                                <tr> 
                                    <td class="p-2 border border-indigo-500 dark:border-indigo-400">
                                        {{ $micro->tipoMicro->nombre ?? '-' }}
                                    </td>
                                    <td class="p-2 border border-indigo-500 dark:border-indigo-400">
                                        {{ $micro->cantidad }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic bg-gray-50 dark:bg-gray-700 p-3 rounded text-center text-sm sm:text-base">No tiene reservas registradas.</p>
        @endforelse

        <div class="mt-8 text-center">
            <a href="{{ url()->previous() }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Volver</a>
        </div>

    </div>
</x-app-layout>
