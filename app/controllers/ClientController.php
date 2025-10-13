<?php
require_once __DIR__ . '/../models/Clients.php';
class ClientController{
    public function index() {
        $title = "Clientes";
        $clientes = Clients::all();
        require_once __DIR__ . '/../views/clientes/show.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
        
    }
    public function create(){
        $title = "Registrar Cliente";
        require_once __DIR__ . '/../views/clientes/create.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';

    }
    public function store(){
        $data = [$_POST['name'],$_POST['phone'],1];
        Clients::store($data);
        header("Location: /clientes");
    }
    public function edit(){
        $title = "Editar Cliente";
        $id = $_POST["id"];
        $client = Clients::getClient($id);
        require_once __DIR__ . '/../views/clientes/edit.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';

    }
    public function update(){
        $data = [
            'nombre' => $_POST['name'],
            'telefono' => $_POST['phone'],
            'id' => $_POST['id'],
        ];
        
        Clients::update($data);
        header("Location: /clientes");
    }

    public function delete() {
        $id = $_POST['id'];
        Clients::delete($id);
        header("Location: /clientes");
    }
}
?>