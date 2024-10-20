<?php
require_once './models/UsuarioModel.php';
require_once './helpers/AuthHelper.php';

class UsuariosController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        session_start();
    }

    // Muestra el formulario de login
    public function mostrarLogin() {
        require './views/login.phtml';
    }

    // Procesa el login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Verificar el usuario y contraseña
            $usuario = $this->usuarioModel->getUserByUsernameAndPassword($username, $password);

            if ($usuario) {
                // Si las credenciales son correctas, inicia sesión
                AuthHelper::login($usuario); // Usamos el helper para manejar la sesión
                header('Location: router.php?controller=categorias&action=index');
                exit();
            } else {
                // Si las credenciales son incorrectas, muestra un error en el login
                $error = "Usuario o contraseña incorrectos";
                require './views/login.phtml';
            }
        } else {
            // Si no es una petición POST, muestra el formulario
            require './views/login.phtml';
        }
    }

    // Cierra la sesión (logout)
    public function logout() {
        AuthHelper::logout(); // Usamos el helper para destruir la sesión y redirigir
    }
}
