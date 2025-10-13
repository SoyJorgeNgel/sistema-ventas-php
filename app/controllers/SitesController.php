<?php
class SitesCotroller{
    public function login() {
        require_once __DIR__ . '/../views/login.php';
    }
    public function inicio(){
        require_once __DIR__ . '/../views/inicio.php';
    }
    public function pageNotFound() {
        require_once __DIR__ . '/../views/error/404.html';   
    }
}
?>