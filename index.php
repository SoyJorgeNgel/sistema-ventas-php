<?php
session_start();
if (isset($_SESSION['nombre'])) {
    header("Location: /inicio"); // Corregido: redirigir a /inicio en lugar de /login
} else {
    header("Location: /login");
}
