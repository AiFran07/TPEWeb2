<?php
// Iniciar sesión (si es necesario)
session_start();

// Incluir archivo de configuración
require_once __DIR__ . '/../config/config.php';

// Autoload de clases (puedes usar Composer o implementar tu propio autoload)
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../app/' . str_replace('\\', '/', $class_name) . '.php';
});

// Obtener la URI solicitada y descomponerla en segmentos
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Definir el controlador y la acción por defecto
$controller_name = !empty($request_uri[0]) ? ucfirst(array_shift($request_uri)) . 'Controller' : 'HomeController';
$action_name = !empty($request_uri) ? array_shift($request_uri) : 'index';

// Construir el nombre completo del controlador con su espacio de nombres
$controller_class = 'App\\Controllers\\' . $controller_name;

// Verificar si el controlador existe
if (class_exists($controller_class)) {
    $controller = new $controller_class();
    
    // Verificar si la acción existe en el controlador
    if (method_exists($controller, $action_name)) {
        // Llamar a la acción del controlador con los parámetros restantes de la URI
        call_user_func_array([$controller, $action_name], $request_uri);
    } else {
        // Acción no encontrada, lanzar un error 404
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found: Acción no encontrada.";
    }
} else {
    // Controlador no encontrado, lanzar un error 404
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found: Controlador no encontrado.";
}
