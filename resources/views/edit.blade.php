{{-- Define las clases base para todos los inputs para no repetirlas --}}
@php
    $inputClasses = 'w-full rounded-lg border-slate-600 bg-slate-700 text-white placeholder:text-gray-500 focus:border-indigo-500 focus:ring-indigo-500';
@endphp

<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="bg-slate-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto pt-12">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white sm:text-4xl">
                    Editar Reserva #{{ $reserva->id }}
                </h2>
                <p class="mt-2 text-lg text-gray-400">
                    Cliente: {{ $reserva->cliente->nombre }} {{ $reserva->cliente->apellido }}
                </p>
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
                                <h4 class="font-semibold mb-3 text-gray-300">Micros ya asignados</h4>
                                @forelse($reserva->micros as $micro)
                                    <div class="flex items-center justify-between py-2 text-gray-300">
                                        <p><span class="font-bold text-indigo-400">{{ $micro->cantidad }}x</span> {{ $micro->tipoMicro->nombre }}</p>
                                        <span class="text-xs text-gray-500">Capacidad: {{ $micro->tipoMicro->capacidad }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic py-2">No hay micros asignados.</p>
                                @endforelse
                            </div>

                            <div class="mt-6">
                                <h4 class="font-semibold mb-3 text-gray-300">Agregar nuevo micro a la reserva</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/70 p-4 rounded-lg">
                                    <div>
                                        <label for="nuevo_tipo_micro_id" class="block text-sm font-medium text-gray-400 mb-1">Tipo de micro</label>
                                        <select id="nuevo_tipo_micro_id" name="nuevo_tipo_micro_id" class="{{ $inputClasses }}">
                                            <option value="">-- No agregar --</option>
                                            @foreach($tiposMicro as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }} (Cap: {{ $tipo->capacidad }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nueva_cantidad_micro" class="block text-sm font-medium text-gray-400 mb-1">Cantidad</label>
                                        <input type="number" min="1" id="nueva_cantidad_micro" name="nueva_cantidad_micro" placeholder="Ej: 1" class="{{ $inputClasses }}">
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