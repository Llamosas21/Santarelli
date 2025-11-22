<?php


$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Si el archivo existe físicamente en public (imágenes, css, js), sírvelo directo.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false; 
}

// Si no, carga el index.php real de Laravel
require_once __DIR__.'/public/index.php';