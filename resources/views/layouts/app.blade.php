<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Santarelli') }}</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        @auth
        <script>
            (function() {
                // Obtenemos la URL de nuestra API de conteo (la que creamos en web.php)
                const countApiUrl = "{{ route('api.reservas.count') }}";
                let currentReservationCount = -1;

                // 1. Función para revisar si hay nuevas reservas
                const checkForNewReservations = () => {
                    fetch(countApiUrl)
                        .then(response => {
                            // Si la respuesta no es OK (ej. 404, 500), no hacemos nada
                            if (!response.ok) {
                                console.error('Error al verificar el conteo de reservas.');
                                return;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return; // Si hubo un error en el fetch anterior

                            const newCount = data.count;
                            
                            // Si es la primera vez que revisa, solo guarda el número inicial
                            if (currentReservationCount === -1) {
                                currentReservationCount = newCount;
                                return; 
                            }

                            // Si el nuevo conteo es DIFERENTE al que teníamos,
                            // ¡significa que algo cambió!
                            if (newCount !== currentReservationCount) {
                                location.reload(); // Forzamos la recarga de la página
                            }
                        })
                        .catch(err => console.error('Error de red al revisar conteo:', err));
                };

                // 2. Revisamos por primera vez al cargar la página
                checkForNewReservations();

                // 3. Repetimos la revisión cada 10 segundos
                setInterval(checkForNewReservations, 10000); 
            })();
        </script>
        @endauth
    </body>
</html>