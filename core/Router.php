<?php
//$url = $_SERVER['REQUEST_URI'];
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalizar la URL - quitar diagonal al final excepto para la raíz
$url = $url === '/' ? '/' : rtrim($url, '/');

// Función para verificar si el usuario está autenticado
function isAuthenticated() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['nombre']);
}

// Rutas que NO requieren autenticación
$publicRoutes = ['/', '/index', '/login', '/apisesion'];

// Si la ruta requiere autenticación y el usuario no está autenticado, redirigir a login
if (!in_array($url, $publicRoutes) && !isAuthenticated()) {
    header("Location: /login");
    exit;
}

switch ($url) {
    case '/':
    case '/index':
    case '/login':
        session_start();
        if (isset($_SESSION['nombre'])) {
            header("Location: /inicio"); // Corregido: redirigir a /inicio en lugar de /login
            exit;
        }
        require_once __DIR__ . '/../app/controllers/SitesController.php';
        $controller = new SitesCotroller();
        $controller->login();
        break;
    case '/inicio':
        require_once __DIR__ . '/../app/controllers/SitesController.php';
        $controller = new SitesCotroller();
        $controller->inicio();
        break;
    case '/apisesion':
        require_once __DIR__ . '/../app/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->login();
        break;
    case '/usuarios':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->index();
        break;
    case '/usuarios/crear':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->create();
        break;
    case '/usuarios/api/crearUsuario':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->store();
        break;
    case '/usuarios/api/editarUsuario':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->edit();
        break;
    case '/usuarios/api/actualizarUsuario':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->update();
        break;
    case '/usuarios/api/desactivarUsuario':
        require_once __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->delete();
        break;
    case '/proveedores':
        require_once __DIR__ . '/../app/controllers/ProviderController.php';
        $controller = new ProviderController();
        $controller->index();
        break;
    case '/proveedores/crear':
        require_once __DIR__ . '/../app/controllers/ProviderController.php';
        $controller = new ProviderController();
        $controller->create();
        break;
    case '/proveedor/api/crearProveedor':
        require_once __DIR__ . '/../app/controllers/ProviderController.php';
        $controller = new ProviderController();
        $controller->store();
        break;
    case '/proveedores/editarProveedor':
        require_once __DIR__ . '/../app/controllers/ProviderController.php';
        $controller = new ProviderController();
        $controller->edit();
        break;
    case '/proveedor/api/actualizarProveedor':
        require_once __DIR__ . '/../app/controllers/ProviderController.php';
        $controller = new ProviderController();
        $controller->update();
        break;
    case '/proveedores/api/desactivarProveedor':
        require_once __DIR__ . '/../app/controllers/ProviderController.php';
        $controller = new ProviderController();
        $controller->delete();
        break;
    case '/productos':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;
    case '/productos/crear':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->create();
        break;
    case '/productos/api/crearProducto':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->store();
        break;
    case '/productos/editarProducto':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->edit();
        break;
    case '/productos/api/actualizarProducto':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->update();
        break;
    case '/productos/api/desactivarProducto':
        require_once __DIR__ . '/../app/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->delete();
        break;
    case '/clientes':
        require_once __DIR__ . '/../app/controllers/ClientController.php';
        $controller = new ClientController();
        $controller->index();
        break;
    case '/clientes/crear':
        require_once __DIR__ . '/../app/controllers/ClientController.php';
        $controller = new ClientController();
        $controller->create();
        break;
    case '/clientes/api/crearCliente':
        require_once __DIR__ . '/../app/controllers/ClientController.php';
        $controller = new ClientController();
        $controller->store();
        break;
    case '/clientes/editar':
        require_once __DIR__ . '/../app/controllers/ClientController.php';
        $controller = new ClientController();
        $controller->edit();
        break;
    case '/clientes/api/actualizar':
        require_once __DIR__ . '/../app/controllers/ClientController.php';
        $controller = new ClientController();
        $controller->update();
        break;
    case '/clientes/api/desactivar':
        require_once __DIR__ . '/../app/controllers/ClientController.php';
        $controller = new ClientController();
        $controller->delete();
        break;
    case '/ventas':
        require_once __DIR__ . '/../app/controllers/SalesController.php';
        $controller = new SalesController();
        $controller->index();
        break;
    case '/ventas/api/obtenerSiguienteId':
        require_once __DIR__ . '/../app/controllers/SalesController.php';
        $controller = new SalesController();
        $controller->getNextId();
        break;
    case '/ventas/api/storeVentaCompleta':
        require_once __DIR__ . '/../app/controllers/SalesController.php';
        $controller = new SalesController();
        $controller->storeVentaCompleta();
        break;
    case '/ventas/api/obtenerStock':
        require_once __DIR__ . '/../app/controllers/SalesController.php';
        $controller = new SalesController();
        $controller->getStock();
        break;
    case '/compras':
        require_once __DIR__ . '/../app/controllers/PurchaseController.php';
        $controller = new PurchaseController();
        $controller->index();
        break;
    case '/compras/api/obtenerSiguienteId':
        require_once __DIR__ . '/../app/controllers/PurchaseController.php';
        $controller = new PurchaseController();
        $controller->getNextId();
        break;
    case '/compras/api/obtenerProductosProveedor':
        require_once __DIR__ . '/../app/controllers/PurchaseController.php';
        $controller = new PurchaseController();
        $controller->getProductsByProvider();
        break;
    case '/compras/api/storeCompraCompleta':
        require_once __DIR__ . '/../app/controllers/PurchaseController.php';
        $controller = new PurchaseController();
        $controller->storeCompraCompleta();
        break;
    case '/ticket':
        if (isset($_GET['action']) && $_GET['action'] === 'ticket_venta' && isset($_GET['id'])) {
            require_once __DIR__ . '/../app/controllers/ReportsController.php';
            $reportes = new ReportsController();
            $reportes->generarTicketVenta($_GET['id']);
            exit;
        }
        break;
    case '/logout':
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: /login");
        exit;
        break;

    default:
        require_once __DIR__ . '/../app/controllers/SitesController.php';
        $controller = new SitesCotroller();
        $controller->pageNotFound();
        break;
}
?>