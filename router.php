<?php
require_once 'controllers/itemscontroller.php';
require_once 'controllers/categoriascontroller.php';
require_once 'controllers/usuarioscontroller.php';

// Lógica del router
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'items';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'items':
        $controller = new ItemsController();
        break;
    case 'categorias':
        $controller = new CategoriasController();
        break;
    case 'usuarios':
        $controller = new UsuariosController();
        break;
    default:
        die("Controlador no encontrado.");
}

if (method_exists($controller, $action)) {
    if (isset($_GET['id'])) {
        $controller->$action($_GET['id']);  // Si hay un ID pasamos como parámetro
    } else {
        $controller->$action();  // Sin ID ejecuta directamente
    }
} else {
    die("Acción no encontrada.");
}
