<?php
require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ . '/../models/Providers.php';
class ProductController{
    public function index() {
        $title = "Productos";
        $productos = Products::all();
        include_once __DIR__ . '/../views/productos/show.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
        
    }
    public function create(){
        $title = "Registrar Producto";
        $proveedores = Providers::all(); //obtener todos los proveedores
        require_once __DIR__ . '/../views/productos/create.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }
    public function store(){
        $data = [$_POST['name'],$_POST['desc'],$_POST['cod'],$_POST['compra'],$_POST['venta'],$_POST['stock'],$_POST['prov'], 1];
        print_r($data);
        Products::store($data);
        header("Location: /productos");
    }
    public function edit(){
        $title = "Editar Producto";
    $id = $_POST["id"];

    // PRUEBA: crear conexión manual
    $db = Database::connect();

    // Pásala tú manualmente
    $producto = Products::getProduct($id, $db);
    $proveedores = Providers::getProveiderList($db);

    require_once __DIR__ . '/../views/productos/edit.php';
    require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
}
    public function update(){
        $data = [
            'nombre' => $_POST['name'],
            'descripcion' => $_POST['desc'],
            'codigo_barras' => $_POST['cod'],
            'precio_compra' => $_POST['compra'],
            'precio_venta' => $_POST['venta'],
            'stock_total' => $_POST['stock'],
            'id_proveedor' => $_POST['prov'],
            'id' => $_POST['id']
        ];
        
        Products::update($data);
        header("Location: /productos");
    }

    public function delete() {
        $id = $_POST['id'];
        Products::delete($id);
        header("Location: /productos");
    }
}
?>