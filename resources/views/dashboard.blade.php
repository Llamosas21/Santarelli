<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="w-full border border-gray-300 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-center">
                                <th class="px-4 py-2">Cliente</th>
                                <th class="px-4 py-2">Destino</th>
                                <th class="px-4 py-2">Tipo Micro</th>
                                <th class="px-4 py-2">Cantidad Micros</th>
                                <th class="px-4 py-2">Monto</th>
                                <th class="px-4 py-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservas as $reserva)
                            <tr class="border-t border-gray-300 dark:border-gray-700 text-center">
                                <td class="px-4 py-2 text-center">
                                    {{ $reserva->cliente->nombre ?? '' }} {{ $reserva->cliente->apellido ?? '' }}
                                </td>
                                <td class="px-4 py-2 ">
                                    {{ $reserva->lugar->nombre ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2">
                                    @foreach ($reserva->micros as $micro)
                                        {{ $micro->tipoMicro->nombre }}
                                        @if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="px-4 py-2">
                                    {{ $reserva->micros->sum('cantidad') }}
                                </td>
                                <td class="px-4 py-2">{{ $reserva->monto }}</td>
                                <td class="px-4 py-2">{{ ucfirst($reserva->estado) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                    No hay reservas registradas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>