<?php
class DashboardController {
    public function index() {
        // Lógica para mostrar el dashboard
        require_once __DIR__ . '/../views/dashboard/index.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }
}