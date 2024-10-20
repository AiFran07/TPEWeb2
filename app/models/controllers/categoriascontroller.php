<?php

require_once 'models/CategoriaModel.php';
require_once 'helpers/AuthHelper.php'; // Incluimos el helper de autenticación

class CategoriasController {

    private $categoriaModel;

    public function __construct() {
        $this->categoriaModel = new CategoriaModel();
    }

    // Método para listar todas las categorías
    public function index() {
        $categorias = $this->categoriaModel->getAllCategories();
        require 'views/categorias.phtml';  // Vista para mostrar la lista de categorías
    }

    // Método para mostrar el formulario de creación de una categoría (solo admins)
    public function create() {
        AuthHelper::checkLoggedIn();  // Verificamos que esté logueado
        require 'views/category_form.phtml';  // Vista para el formulario de creación
    }

    // Método para procesar la creación de una nueva categoría (solo admins)
    public function store() {
        AuthHelper::checkLoggedIn();  // Verificamos que esté logueado
        $nombre = $_POST['nombre'];

        // Validación
        if (empty($nombre)) {
            echo "Error: El nombre de la categoría es obligatorio.";
            return;
        }

        // Creación de categoría
        try {
            $this->categoriaModel->createCategory($nombre);
            header('Location: router.php?controller=categorias&action=index'); // Redirigir a la lista de categorías
        } catch (Exception $e) {
            echo "Error al crear la categoría: " . $e->getMessage();
        }
    }

    // Método para mostrar el formulario de edición de una categoría (solo admins)
    public function edit($id) {
        AuthHelper::checkLoggedIn();  // Verificamos que esté logueado
        $categoria = $this->categoriaModel->getCategoryById($id);
        if (!$categoria) {
            echo "Categoría no encontrada.";
            return;
        }
        require 'views/category_form.phtml';  // Reutilizamos el formulario para editar
    }

    // Método para procesar la edición de una categoría (solo admins)
    public function update($id) {
        AuthHelper::checkLoggedIn();  // Verificamos que esté logueado
        $nombre = $_POST['nombre'];

        // Validación
        if (empty($nombre)) {
            echo "Error: El nombre de la categoría es obligatorio.";
            return;
        }

        // Actualización de categoría
        try {
            $this->categoriaModel->updateCategory($id, $nombre);
            header('Location: router.php?controller=categorias&action=index');
        } catch (Exception $e) {
            echo "Error al actualizar la categoría: " . $e->getMessage();
        }
    }

    // Método para eliminar una categoría (solo admins)
    public function delete($id) {
        AuthHelper::checkLoggedIn();  // Verificamos que esté logueado

        try {
            $this->categoriaModel->deleteCategory($id);
            header('Location: router.php?controller=categorias&action=index');
        } catch (Exception $e) {
            echo "Error al eliminar la categoría: " . $e->getMessage();
        }
    }
}
