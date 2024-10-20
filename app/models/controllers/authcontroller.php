<?php
class AuthController {

    // Mostrar el formulario de login
    public function loginForm() {
        require 'views/login.phtml'; // El formulario de login
    }

    // Procesar el formulario de login
    public function login() {
        // Obtener los datos del formulario
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cargar el modelo de usuario
        require_once 'models/UsuarioModel.php';
        $usuarioModel = new UsuarioModel();

        // Verificar si el usuario existe y la contraseña es correcta
        $user = $usuarioModel->getUserByUsername($username);

        if ($user && md5($password) == $user['password']) {
            // Iniciar sesión
            session_start();
            $_SESSION['admin'] = true; // Marcar que el usuario está logueado
            header('Location: router.php?controller=categorias&action=index');
        } else {
            // Mostrar un error
            $error = "Usuario o contraseña incorrectos";
            require 'views/login.phtml'; // Volver a mostrar el formulario de login
        }
    }

    // Cerrar sesión (logout)
    public function logout() {
        session_start();
        session_destroy(); // Cerrar la sesión
        header('Location: router.php?controller=auth&action=loginForm');
    }
}
?>
