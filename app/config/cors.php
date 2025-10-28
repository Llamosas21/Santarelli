<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*'], // Aplica CORS solo a tus rutas de API

    'allowed_methods' => ['*'], // Permite todos los métodos (GET, POST, etc.)

    'allowed_origins' => ['*'], // Se debe cambiar al dominio específico del formulario

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];