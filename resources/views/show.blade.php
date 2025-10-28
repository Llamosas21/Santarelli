<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12 sm:pb-16">

        <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-gray-900 dark:text-gray-100 text-center sm:text-left">
            Detalles de {{ $cliente->nombre }} {{ $cliente->apellido }}
        </h2>

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

        @forelse($cliente->reservas as $reserva)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 sm:p-6 mb-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4">
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

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-lg mb-2 text-indigo-700 dark:text-indigo-400">Horarios</h4>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Fecha salida:</span> {{ optional($reserva->horario)->fecha_salida ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Fecha regreso:</span> {{ optional($reserva->horario)->fecha_regreso ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-200"><span class="font-semibold">Lugar de salida:</span> {{ $reserva->lugar->direccion ?? '-' }}</p>
                    </div>
                </div>

                <div class="bg-slate-900/70 p-4 rounded-lg">
                    <h4 class="font-semibold text-lg mb-2 text-indigo-700 dark:text-indigo-400">Micros reservados</h4>

                    @if($reserva->microsAgrupados->isNotEmpty())
                        <div class="overflow-x-auto rounded-lg">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-700">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 text-left font-semibold text-gray-300">Tipo de micro</th>
                                        <th scope="col" class="px-4 py-2 text-center font-semibold text-gray-300">Cantidad</th>
                                        <th scope="col" class="px-4 py-2 text-center font-semibold text-gray-300">Capacidad Unit.</th>
                                        <th scope="col" class="px-4 py-2 text-center font-semibold text-gray-300">Subtotal Pasajeros</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700">
                                    @foreach($reserva->microsAgrupados as $micro)
                                        <tr class="bg-slate-800">
                                            <td class="px-4 py-2 font-medium text-gray-300">
                                                {{ $micro->tipoMicro->nombre ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 text-center text-gray-300">
                                                {{ $micro->cantidad }}
                                            </td>
                                            <td class="px-4 py-2 text-center text-gray-400">
                                                {{ $micro->tipoMicro->capacidad }}
                                            </td>
                                            <td class="px-4 py-2 text-center font-medium text-gray-300">
                                                {{ $micro->cantidad * $micro->tipoMicro->capacidad }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-slate-700 font-bold text-gray-200">
                                    <tr>
                                        <td class="px-4 py-2 text-left" colspan="1">TOTAL</td>
                                        <td class="px-4 py-2 text-center">
                                            {{ $reserva->microsAgrupados->sum('cantidad') }}
                                        </td>
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2 text-center">
                                            {{ $reserva->microsAgrupados->reduce(fn($carry, $micro) => $carry + ($micro->cantidad * $micro->tipoMicro->capacidad), 0) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p class="text-sm italic bg-slate-800 p-3 rounded-lg text-gray-500">No hay micros asignados.</p>
                    @endif
                </div>
            </div>           
        @empty
            <p class="text-gray-500 italic bg-gray-50 dark:bg-gray-700 p-3 rounded text-center text-sm sm:text-base">No tiene reservas registradas.</p>
        @endforelse

        <div class="mt-8 text-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Volver al Panel
            </a>
        </div>

    </div>
</x-app-layout>