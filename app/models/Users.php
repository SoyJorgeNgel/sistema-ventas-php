<?php
require_once __DIR__ . '/../../core/Database.php';
class Users
{
    public static function all()
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function store($data)
    {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, correo, telefono, password, rol, estado) 
                      VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute($data);
    }
    public static function update($data)
    {
        $db = Database::connect($data);
        print_r($data);
        $pass = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono, password = :password, rol = :rol WHERE id = :id");
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':correo' => $data['correo'],
            ':telefono' => $data['telefono'],
            ':password' => $pass,
            ':rol' => $data['rol'],
            ':id' => $data['id']
        ]);
    }
    public static function delete($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE usuarios SET estado = 0 WHERE id = $id");
        $stmt->execute();
    }
    public static function getUser($id)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
