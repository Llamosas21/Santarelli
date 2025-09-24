<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="w-full border border-gray-300 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-2 text-left">Cliente</th>
                                <th class="px-4 py-2 text-left">Lugar</th>
                                <th class="px-4 py-2 text-left">Tipo Micro</th>
                                <th class="px-4 py-2 text-left">Cantidad Micros</th>
                                <th class="px-4 py-2 text-left">Monto</th>
                                <th class="px-4 py-2 text-left">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservas as $reserva)
                            <tr class="border-t border-gray-300 dark:border-gray-700">
                                <td class="px-4 py-2">{{ $reserva->cliente }}</td>
                                <td class="px-4 py-2">{{ $reserva->lugar }}</td>
                                <td class="px-4 py-2">{{ $reserva->tipo_micro }}</td>
                                <td class="px-4 py-2">{{ $reserva->cantidad_micros }}</td>
                                <td class="px-4 py-2">{{ $reserva->monto }}</td>
                                <td class="px-4 py-2">{{ $reserva->estado }}</td>
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