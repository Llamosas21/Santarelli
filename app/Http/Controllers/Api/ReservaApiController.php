<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\LugarDestino;
use App\Models\TipoMicro;
use App\Models\HorarioReserva;
use App\Models\MicroReserva;
use App\Models\Contacto;

class ReservaApiController extends Controller
{
    public function store(Request $request)
    {
        // --- 1. DEFINICIONES (Sin cambios) ---
        $destinos_validos = [
            'Museo Benito Quinquela Martín' => 'Avenida Don Pedro de Mendoza 1835, CABA',
            'Manzana de las Luces' => 'Perú 272, CABA',
            'Palacio Barolo' => 'Avenida de Mayo 1370, CABA',
            'Cementerio de la Chacarita' => 'Avenida Guzmán 680, CABA',
            'Jardín Japonés' => 'Av. Casares 3450, CABA',
            'El Zanjón de Granados' => 'Defensa 755, CABA',
        ]; 

        $micros_validos = [
            '20 personas' => ['capacidad' => 20, 'precio_base' => 25000.00],
            '40 personas' => ['capacidad' => 40, 'precio_base' => 45000.00],
            '60 personas' => ['capacidad' => 60, 'precio_base' => 60000.00],
        ];

        // --- 2. VALIDACIÓN (AJUSTADA PARA ARRAYS) ---
        
        // Obtenemos los datos para una validación más robusta
        $data = $request->all();
        // Contamos cuántos ítems 'micro' vienen, para que 'cantidad_micros' coincida
        $microCount = count($data['micro'] ?? []); 

        $validator = Validator::make($data, [
            'nombre' => 'required|string|min:2|max:50',
            'apellido' => 'required|string|min:2|max:50',
            'telefono' => 'required|string|min:7|max:20',
            'email' => 'required|email|max:100',
            'destino' => ['required', 'string', Rule::in(array_keys($destinos_validos))],
            
            // --- REGLAS CORREGIDAS ---
            // 'micro' debe ser un array, con al menos 1 ítem
            'micro' => 'required|array|min:1', 
            // CADA ítem ('*') dentro del array 'micro' debe ser un string válido
            'micro.*' => ['required', 'string', Rule::in(array_keys($micros_validos))], 
            
            // 'cantidad_micros' debe ser un array, y tener el MISMO TAMAÑO que 'micro'
            'cantidad_micros' => "required|array|min:1|size:$microCount", 
            // CADA ítem ('*') dentro de 'cantidad_micros' debe ser un entero válido
            'cantidad_micros.*' => 'required|integer|min:1|max:10', 

            'fecha_salida' => 'required|date|after:now',
            'fecha_regreso' => 'required|date|after:fecha_salida',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $validator->errors()
            ], 422);
        }

        // --- 3. LÓGICA DE NEGOCIO Y MODELOS (AJUSTADA PARA ARRAYS) ---

        try {
            $reservaGuardada = DB::transaction(function () use ($request, $micros_validos, $destinos_validos) {

                // --- A. CREAR CLIENTE Y CONTACTO (Sin cambios) ---
                // SIEMPRE creamos un NUEVO cliente para cada reserva.
                $cliente = Cliente::create([
                    'nombre' => $request->input('nombre'),
                    'apellido' => $request->input('apellido')
                ]);

                // SIEMPRE creamos un NUEVO contacto asociado a este nuevo cliente.
                $cliente->contactos()->create([
                    'email' => $request->input('email'),
                    'telefono' => $request->input('telefono')
                ]);

                // --- B. OBTENER LUGARDESTINO (Sin cambios) ---
                $destino_nombre = $request->input('destino');
                $lugarDestino = LugarDestino::firstOrCreate(
                    ['nombre' => $destino_nombre], 
                    ['direccion' => $destinos_validos[$destino_nombre]]
                );

                // --- C. PROCESAR MICROS Y CALCULAR TOTALES (Lógica nueva) ---
                $micros_input = $request->input('micro'); // Ej: ['40 personas', '20 personas']
                $cantidades_input = $request->input('cantidad_micros'); // Ej: [2, 1]
                
                $monto_total_final = 0;
                $pasajeros_total_final = 0;
                $micros_para_guardar = []; // Array temporal

                foreach ($micros_input as $index => $micro_nombre) {
                    $cantidad = (int)$cantidades_input[$index];
                    $datos_micro = $micros_validos[$micro_nombre];

                    // Buscar o crear el TipoMicro en la BD
                    $tipoMicro = TipoMicro::firstOrCreate(
                        ['nombre' => $micro_nombre], 
                        [
                            'capacidad' => $datos_micro['capacidad'], 
                            'precio_base' => $datos_micro['precio_base']
                        ]
                    );

                    // Acumular totales para la reserva principal
                    $monto_total_final += $datos_micro['precio_base'] * $cantidad;
                    $pasajeros_total_final += $datos_micro['capacidad'] * $cantidad;

                    // Guardar los datos para la tabla pivote 'micro_reservas'
                    $micros_para_guardar[] = [
                        'tipo_micro_id' => $tipoMicro->id,
                        'cantidad' => $cantidad
                    ];
                }

                // --- D. CREAR LA RESERVA (Ahora con totales acumulados) ---
                $reserva = Reserva::create([
                    'cliente_id' => $cliente->id,
                    'lugar_id' => $lugarDestino->id,
                    'cantidad_pasajeros' => $pasajeros_total_final, // Total de pasajeros
                    'monto' => $monto_total_final, // Monto total
                    'estado' => 'pendiente',
                ]);

                // --- E. CREAR HORARIO (Sin cambios) ---
                $reserva->horario()->create([
                    'fecha_salida' => $request->input('fecha_salida'), 
                    'fecha_regreso' => $request->input('fecha_regreso')
                ]);
                
                // --- F. GUARDAR LOS MICROS (Lógica nueva) ---
                // Se insertan todas las filas de micros asociadas a esta reserva
                $reserva->micros()->createMany($micros_para_guardar);

                return $reserva;
            });

            // --- 4. RESPUESTA EXITOSA ---
            // El JS del frontend espera 'reserva_id' para mostrarlo
            return response()->json([
                'message' => 'Reserva creada exitosamente.',
                'reserva_id' => $reservaGuardada->id 
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno al guardar la reserva.',
                // 'debug' => $e->getMessage() // Descomentar solo para depurar
            ], 500);
        }
    }
}