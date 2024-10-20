<?php

class ItemModel {

    private $db;

    public function __construct() {
        // Configuración de la conexión a la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=motoresar.sql;charset=utf8', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Obtener todos los ítems (vehículos)
    public function getAllItems() {
        $query = $this->db->prepare('SELECT vehiculos.*, categorias.nombre AS categoria 
                                     FROM vehiculos 
                                     JOIN categorias ON vehiculos.id_categoria = categorias.id');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un ítem por ID
    public function getItemById($id) {
        $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo ítem
    public function createItem($modelo, $anio, $precio, $kilometraje, $descripcion, $id_categoria) {
        $query = $this->db->prepare('INSERT INTO vehiculos (modelo, anio, precio, kilometraje, descripcion, id_categoria) 
                                     VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$modelo, $anio, $precio, $kilometraje, $descripcion, $id_categoria]);
    }

    // Actualizar un ítem existente
    public function updateItem($id, $modelo, $anio, $precio, $kilometraje, $descripcion, $id_categoria) {
        $query = $this->db->prepare('UPDATE vehiculos 
                                     SET modelo = ?, anio = ?, precio = ?, kilometraje = ?, descripcion = ?, id_categoria = ? 
                                     WHERE id = ?');
        $query->execute([$modelo, $anio, $precio, $kilometraje, $descripcion, $id_categoria, $id]);
    }

    // Eliminar un ítem por ID
    public function deleteItem($id) {
        $query = $this->db->prepare('DELETE FROM vehiculos WHERE id = ?');
        $query->execute([$id]);
    }

}
