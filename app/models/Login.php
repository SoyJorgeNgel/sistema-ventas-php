<?php
require_once __DIR__ . '/../../core/Database.php';
class Login
{
    public static function searchUser($email, $pass)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($pass, $row['password'])) {
            session_start();
            $_SESSION['id_vendedor'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['rol'] = $row['rol'];

            return true; // usuario válido
        } else {
            return false; // credenciales incorrectas
        }
    }
}
