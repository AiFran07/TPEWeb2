<?php

class AuthHelper {

    // Verificar si el usuario está logueado
    public static function checkLoggedIn() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Si no está logueado, redirigir a la página de login
            header('Location: router.php?controller=usuarios&action=login');
            exit();
        }
    }

    // Verificar si el usuario tiene permisos de administrador
    public static function isAdmin() {
        session_start();
        // Aseguramos que el usuario tenga el rol de 'admin'
        return (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
    }

    // Loguear usuario (guardamos en la sesión)
    public static function login($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role']; // Asumimos que existe un campo 'role' en la tabla de usuarios
    }

    // Desloguear usuario
    public static function logout() {
        session_start();
        session_destroy();
        header('Location: router.php?controller=usuarios&action=login');
        exit();
    }
}
