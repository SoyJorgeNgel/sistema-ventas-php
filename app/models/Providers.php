<?php
require_once __DIR__ . '/../../core/Database.php';

class Providers
{
    private static $db = null;

    private static function connect()
    {
        if (!self::$db) {
            self::$db = Database::connect();
        }
        return self::$db;
    }

    public static function all()
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM proveedores WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function store($data)
    {
        $db = self::connect();
        $stmt = $db->prepare("INSERT INTO proveedores (nombre, contacto, telefono, correo, estado) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute($data);
    }

    public static function update($data)
    {
        $db = self::connect();
        $stmt = $db->prepare("
            UPDATE proveedores 
            SET nombre = :nombre, contacto = :contacto, telefono = :telefono, correo = :correo 
            WHERE id = :id
        ");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':contacto' => $data['contacto'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':id' => $data['id']
        ]);
    }

    public static function delete($id)
    {
        $db = self::connect();
        $stmt = $db->prepare("UPDATE proveedores SET estado = 0 WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getProveider($id)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM proveedores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function getProveiderList($db)
    {
        $stmt = $db->query("SELECT id, nombre FROM proveedores WHERE estado != 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
