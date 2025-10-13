<?php
require_once __DIR__ . '/../models/Providers.php';
class ProviderController{
    public function index() {
        $title = "Proveedores";
        $proveedores = Providers::all();
        require_once __DIR__ . '/../views/proveedores/show.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }
    public function create(){
        $title = "Registrar Proveedor";
        require_once __DIR__ . '/../views/proveedores/create.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';

    }
    public function store(){
        $data = [$_POST['name'],$_POST['contact'],$_POST['phone'],$_POST['email'],1];
        Providers::store($data);
        header("Location: /proveedores");
    }
    public function edit(){
        $title = "Editar Proveedor";
        $id = $_POST["id"];
        $provider = Providers::getProveider($id);
        require_once __DIR__ . '/../views/proveedores/edit.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';

    }
    public function update(){
        $data = [
            'nombre' => $_POST['name'],
            'contacto' => $_POST['contact'],
            'telefono' => $_POST['phone'],
            'correo' => $_POST['email'],
            'id' => $_POST['id'],
        ];
        
        Providers::update($data);
        header("Location: /proveedores");
    }

    public function delete() {
        $id = $_POST['id'];
        Providers::delete($id);
        header("Location: /proveedores");
    }
}
?>