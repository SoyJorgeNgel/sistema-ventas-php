<?php
require_once __DIR__ . '/../models/Users.php';
class UserController{
    public function index() {
        $title = "Lista de Usuarios";
        // Para verificar si el archivo existe
        $imagePath = __DIR__ . '/../public/assets/logo-negro-El-Bayito.png';
        if (file_exists($imagePath)) {
            echo "El archivo existe";
        } else {
            echo "El archivo NO existe en: " . $imagePath;
        }
        echo "XD";
        ob_start();
        $usuarios = Users::all();
        require_once __DIR__ . '/../views/usuarios/show.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
        
    }
    public function create(){
        $title = "Crear Usuario";
        ob_start();
        require_once __DIR__ . '/../views/usuarios/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }
    public function store(){
        $data = [$_POST['name'],$_POST['email'],$_POST['phone'],$_POST['pass'],$_POST['role']];
        Users::store($data);
    }
    public function edit(){
        $title = "Editar Usuario";
        $id = $_POST["id"];
        $user = Users::getUser($id);
        ob_start();
        require_once __DIR__ . '/../views/usuarios/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }
    public function update(){
        $data = [
            'nombre' => $_POST['name'],
            'correo' => $_POST['email'],
            'telefono' => $_POST['phone'],
            'password' => $_POST['pass'],
            'rol' => $_POST['role'],
            'id' => $_POST['id'],
        ];
        
        Users::update($data);
        header("Location: /usuarios");
    }
    public function delete(){
        $id = $_POST['id'];
        Users::delete($id);
    }
}
?>