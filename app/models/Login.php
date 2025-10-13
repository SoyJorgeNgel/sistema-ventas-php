<?php
require_once __DIR__ . '/../../core/Database.php';
class Login{
    public static function searchUser($email, $pass) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE correo = ? AND password = ?");
        $stmt->execute([$email, $pass]);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC); 
        if ($row) {
            session_start();
            $_SESSION['id_vendedor'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['rol'] = $row['rol'];
            return true; //retorna que el usuario existe
        }
    
        return $stmt; //no se encontro el usuario
    }
}

?>
