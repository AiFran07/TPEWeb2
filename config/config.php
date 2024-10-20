<?php
// config/config.php

// Definición de las constantes de conexión a la base de datos
define('DB_HOST', 'localhost');        // Servidor de base de datos
define('DB_NAME', 'tienda');           // Nombre de la base de datos
define('DB_USER', 'root');             // Usuario de la base de datos
define('DB_PASS', 'root');             // Contraseña de la base de datos (deja vacío si no tienes)
define('DB_PORT', '3306');             // Puerto (por defecto es 3306 para MySQL)

// Función para conectar a la base de datos usando PDO
function getDBConnection() {
    try {
        // Configuración de DSN para PDO
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Manejo de errores con excepciones
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Modo de obtención predeterminado
            PDO::ATTR_EMULATE_PREPARES   => false,                   // Deshabilitar emulación de prepares para seguridad
        ];
        
        // Creación de la conexión usando PDO
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;

    } catch (PDOException $e) {
        // Manejo de error en caso de que falle la conexión
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
        exit;
    }
}
?>
