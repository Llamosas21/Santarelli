{{-- Define las clases base para todos los inputs para no repetirlas --}}
@php
    $inputClasses = 'w-full rounded-lg border-slate-600 bg-slate-700 text-white placeholder:text-gray-500 focus:border-indigo-500 focus:ring-indigo-500 caret-indigo-500';
@endphp

<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="bg-slate-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto pt-12">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white sm:text-4xl">
                     {{ $reserva->cliente->nombre }} {{ $reserva->cliente->apellido }}
                </h2>
            </div>

            <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Tarjeta principal del formulario --}}
                <div class="bg-slate-800 shadow-lg rounded-2xl border border-slate-700 overflow-hidden">
                    <div class="p-6 sm:p-8 space-y-8">

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-6">Detalles de la Reserva</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                                <div>
                                    <label for="lugar_id" class="block text-sm font-medium text-gray-400 mb-1">Lugar destino</label>
                                    <select id="lugar_id" name="lugar_id" class="{{ $inputClasses }}">
                                        @foreach($lugares as $lugar)
                                            <option value="{{ $lugar->id }}" @selected(old('lugar_id', $reserva->lugar_id) == $lugar->id)>{{ $lugar->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="fecha_salida" class="block text-sm font-medium text-gray-400 mb-1">Fecha de salida</label>
                                    <input type="datetime-local" id="fecha_salida" name="fecha_salida" value="{{ old('fecha_salida', optional($reserva->horario)->fecha_salida ? \Carbon\Carbon::parse($reserva->horario->fecha_salida)->format('Y-m-d\TH:i') : '') }}" class="{{ $inputClasses }}">
                                </div>
                                <div>
                                    <label for="monto" class="block text-sm font-medium text-gray-400 mb-1">Precio total</label>
                                    <input type="number" step="0.01" id="monto" name="monto" value="{{ old('monto', $reserva->monto) }}" class="{{ $inputClasses }}">
                                </div>
                                <div>
                                    <label for="fecha_regreso" class="block text-sm font-medium text-gray-400 mb-1">Fecha de regreso</label>
                                    <input type="datetime-local" id="fecha_regreso" name="fecha_regreso" value="{{ old('fecha_regreso', optional($reserva->horario)->fecha_regreso ? \Carbon\Carbon::parse($reserva->horario->fecha_regreso)->format('Y-m-d\TH:i') : '') }}" class="{{ $inputClasses }}">
                                </div>
                                <div class="md:col-span-2" x-data="{ estado: '{{ old('estado', $reserva->estado) }}' }">
                                    <label for="estado" class="block text-sm font-medium text-gray-400 mb-1">Estado</label>
                                    <select id="estado" name="estado" x-model="estado"
                                            class="{{ $inputClasses }} font-semibold transition-colors duration-300"
                                            :class="{
                                                'bg-green-600 text-green-100 border-green-500': estado == 'aceptado',
                                                'bg-orange-500 text-orange-100 border-orange-400': estado == 'pendiente',
                                                'bg-red-600 text-red-100 border-red-500': estado == 'rechazado'
                                            }">
                                        <option value="pendiente">Pendiente</option>
                                        <option value="aceptado">Aceptado</option>
                                        <option value="rechazado">Rechazado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-700">

                        <div>
                            <h3 class="text-xl font-semibold text-white mb-6">Gestión de Micros</h3>
                            
                            <div class="bg-slate-900/70 p-4 rounded-lg">
                                <h4 class="font-semibold mb-3 text-gray-300">Micros registrados</h4>
                                
                                @if($reserva->micros->isNotEmpty())
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
                                                @foreach($reserva->micros as $micro)
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
                                            <tfoot class="bg-slate-700">
                                                <tr>
                                                    <td class="px-4 py-2 text-left font-bold text-gray-200" colspan="1">TOTAL</td>
                                                    <td class="px-4 py-2 text-center font-bold text-gray-200">
                                                        {{ $reserva->micros->sum('cantidad') }}
                                                    </td>
                                                    <td class="px-4 py-2"></td> {{-- Celda vacía para alinear --}}
                                                    <td class="px-4 py-2 text-center font-bold text-gray-200">
                                                        {{-- Suma total de la capacidad de pasajeros --}}
                                                        {{ $reserva->micros->reduce(function ($carry, $micro) {
                                                            return $carry + ($micro->cantidad * $micro->tipoMicro->capacidad);
                                                        }, 0) }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic py-2">No hay micros asignados.</p>
                                @endif
                            </div>
                            <div class="mt-6">
                                <h4 class="font-semibold mb-3 text-gray-300">Agregar nuevo micro a la reserva</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/70 p-4 rounded-lg">
                                    <div>
                                        <label for="nuevo_tipo_micro_id" class="block text-sm font-medium text-gray-400 mb-1">Tipo de micro</label>
                                        <select id="nuevo_tipo_micro_id" name="nuevo_tipo_micro_id" class="{{ $inputClasses }}">
                                            <option value="">Seleccionar</option>
                                            @foreach($tiposMicro as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }} (Cap: {{ $tipo->capacidad }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nueva_cantidad_micro" class="block text-sm font-medium text-gray-400 mb-1">Cantidad</label>
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" min="1" id="nueva_cantidad_micro" name="nueva_cantidad_micro" placeholder="1" class="{{ $inputClasses }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 sm:px-8 py-4 bg-slate-800/50 border-t border-slate-700 flex items-center justify-end gap-x-6">
                        <a href="{{ route('clientes.show', $reserva->cliente_id) }}" class="text-sm font-semibold text-gray-400 hover:text-white transition">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg transition duration-300 shadow-lg shadow-indigo-600/20">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>