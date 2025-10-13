<?php
require_once __DIR__ . '/../../core/Database.php';
class Products
{
    public static function all()
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT productos.id, productos.nombre, productos.descripcion, productos.codigo_barras, 
        productos.precio_venta, productos.precio_compra, productos.stock_total,proveedores.nombre as proveedor
        FROM productos 
        INNER JOIN proveedores ON productos.id_proveedor = proveedores.id 
        WHERE productos.estado != 0;
");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function store($data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO productos (nombre, descripcion, codigo_barras, precio_compra, precio_venta, stock_total, id_proveedor, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute($data);
    }
    public static function update($data)
    {
        $db = Database::connect($data);
        print_r($data);
        // Actualiza el producto en la base de datos
        $stmt = $db->prepare("UPDATE productos SET nombre = :nombre, descripcion = :descripcion, 
        codigo_barras = :codigo_barras, precio_compra = :precio_compra, precio_venta = :precio_venta, 
        stock_total = :stock_total, id_proveedor = :id_proveedor, estado = 1 
        WHERE id = :id");
        $stmt -> execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':codigo_barras' => $data['codigo_barras'],
            ':precio_compra' => $data['precio_compra'],
            ':precio_venta' => $data['precio_venta'],
            ':stock_total' => $data['stock_total'],
            ':id_proveedor' => $data['id_proveedor'],
            ':id' => $data['id']
        ]);
        /*$stmt = $db->prepare("UPDATE proveedores SET nombre = :nombre, contacto = :contacto, telefono = :telefono, correo = :correo WHERE id = :id");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':contacto' => $data['contacto'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':id' => $data['id']
        ]);*/
    }
    public static function delete($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE productos SET estado = 0 WHERE id = $id");
        $stmt->execute();
    }
    public static function getProduct($id, $db)
    {
        $stmt = $db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
