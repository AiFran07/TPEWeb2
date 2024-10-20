<?php

class UsuarioModel {

    private $db;

    public function __construct() {
        require_once 'config/config.php'; // Cargar configuración
        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    // Método para obtener un usuario por nombre de usuario
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para verificar la contraseña del usuario
    public function verifyPassword($username, $password) {
        $user = $this->getUserByUsername($username);

        // Si el usuario existe y la contraseña coincide
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Devuelve el usuario si la contraseña es correcta
        }

        return false;  // Si no coincide o no existe, retorna falso
    }

    // Método para crear un usuario con contraseña cifrada
    public function createUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Cifrar contraseña
        $stmt = $this->db->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
    }
}
