<?php
require_once __DIR__ . '/../../core/Database.php';
class Clients
{
    public static function all()
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function store($data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO clientes (nombre, telefono, estado) VALUES (?, ?, ?)");
        $stmt->execute($data);
    }
    public static function update($data)
    {
        $db = Database::connect($data);
        print_r($data);
        $stmt = $db->prepare("UPDATE clientes SET nombre = :nombre, telefono = :telefono WHERE id = :id");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':telefono' => $data['telefono'],
            ':id' => $data['id']
        ]);
    }
    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE clientes SET estado = 0 WHERE id = $id");
        $stmt->execute();
    }
    public static function getClient($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
    public static function getProveiderList($db) {
    $stmt = $db->query("SELECT id, nombre FROM proveedores WHERE estado != 0");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/
}
