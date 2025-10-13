<?php
require_once __DIR__ . '/../models/Login.php';
class LoginController{
    public static function login() {
        // Obtener el cuerpo JSON
        $jsonData = file_get_contents('php://input');
        // Decodificar a array asociativo
        $data = json_decode($jsonData, true);
        $email = $data['email'] ?? '';
        $pass = $data['pass'] ?? '';        
        print_r( json_encode(Login::searchUser($email,$pass)));
    }
}
?>