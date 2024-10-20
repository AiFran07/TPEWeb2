<?php
require_once 'models/ItemModel.php';
require_once 'models/CategoriaModel.php';
require_once 'helpers/AuthHelper.php'; // Incluimos el helper de autenticación

class ItemsController {

    // Acción para listar todos los ítems (vehículos)
    public function index() {
        $itemModel = new ItemModel();
        $items = $itemModel->getAllItems();
        require 'views/item_list.phtml'; // Lista de ítems
    }

    // Acción para mostrar el formulario de crear ítem (solo admins)
    public function create() {
        AuthHelper::checkLoggedIn(); // Verificamos que esté logueado
        $categoryModel = new CategoriaModel();
        $categorias = $categoryModel->getAllCategories();
        require 'views/item_form.phtml'; // Formulario vacío para crear un nuevo ítem
    }

    // Acción para guardar un nuevo ítem (store)
    public function store() {
        AuthHelper::checkLoggedIn(); // Verificamos que esté logueado
        $modelo = $_POST['modelo'];
        $anio = $_POST['anio'];
        $precio = $_POST['precio'];
        $kilometraje = $_POST['kilometraje'];
        $descripcion = $_POST['descripcion'];
        $id_categoria = $_POST['id_categoria'];

        // Validaciones básicas
        if (empty($modelo) || empty($anio) || empty($precio) || empty($kilometraje) || empty($id_categoria)) {
            echo "Error: Todos los campos son obligatorios.";
            return;
        }

        $itemModel = new ItemModel();
        try {
            $itemModel->createItem($modelo, $anio, $precio, $kilometraje, $descripcion, $id_categoria);
            header('Location: router.php?controller=items&action=index');
        } catch (Exception $e) {
            echo "Error al crear el ítem: " . $e->getMessage();
        }
    }

    // Acción para mostrar el formulario de editar un ítem (solo admins)
    public function edit($id) {
        AuthHelper::checkLoggedIn(); // Verificamos que esté logueado
        $itemModel = new ItemModel();
        $categoryModel = new CategoriaModel();

        $item = $itemModel->getItemById($id);
        $categorias = $categoryModel->getAllCategories();

        if (!$item) {
            echo "Error: El ítem no existe.";
            return;
        }

        require 'views/item_form.phtml'; // Formulario cargado con los datos del ítem a editar
    }

    // Acción para actualizar un ítem existente (solo admins)
    public function update($id) {
        AuthHelper::checkLoggedIn(); // Verificamos que esté logueado
        $modelo = $_POST['modelo'];
        $anio = $_POST['anio'];
        $precio = $_POST['precio'];
        $kilometraje = $_POST['kilometraje'];
        $descripcion = $_POST['descripcion'];
        $id_categoria = $_POST['id_categoria'];

        // Validaciones básicas
        if (empty($modelo) || empty($anio) || empty($precio) || empty($kilometraje) || empty($id_categoria)) {
            echo "Error: Todos los campos son obligatorios.";
            return;
        }

        $itemModel = new ItemModel();
        try {
            $itemModel->updateItem($id, $modelo, $anio, $precio, $kilometraje, $descripcion, $id_categoria);
            header('Location: router.php?controller=items&action=index');
        } catch (Exception $e) {
            echo "Error al actualizar el ítem: " . $e->getMessage();
        }
    }

    // Acción para eliminar un ítem (solo admins)
    public function delete($id) {
        AuthHelper::checkLoggedIn(); // Verificamos que esté logueado

        $itemModel = new ItemModel();
        try {
            $itemModel->deleteItem($id);
            header('Location: router.php?controller=items&action=index');
        } catch (Exception $e) {
            echo "Error al eliminar el ítem: " . $e->getMessage();
        }
    }
}
