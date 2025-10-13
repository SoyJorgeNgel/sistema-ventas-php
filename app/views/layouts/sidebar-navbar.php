<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link href="/scss/custom.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 60px;
        }

        /* Estilos minimalistas para el sidebar */
        .sidebar {
            min-height: 100vh;
            background-color: var(--bs-primary);
            width: var(--sidebar-width);
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            z-index: 100;
            transition: all 0.3s ease;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 12px 20px;
            border: none;
            border-radius: 0;
            transition: all 0.2s ease;
            font-weight: 400;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 25px;
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 3px solid white;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 18px;
            text-align: center;
            font-size: 16px;
        }

        /* Navbar minimalista */
        .navbar {
            background-color: var(--bs-primary) !important;
            height: var(--navbar-height);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0 1rem;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .navbar .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .navbar .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar .nav-link:hover {
            color: white !important;
        }

        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Contenido principal */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 20px;
            transition: all 0.3s ease;
            min-height: calc(100vh - var(--navbar-height));
            background-color: #f8f9fa;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Cards minimalistas */
        .stat-card {
            background: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--bs-primary);
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .content-card {
            background: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .page-header {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                top: var(--navbar-height);
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }

        /* Overlay para móviles */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
    <?= $head ?? '' ?>
</head>

<body>
    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <!-- Botón toggle sidebar -->
            <button class="btn btn-outline-light me-3" type="button" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <a class="navbar-brand" href="index.php">
                <img src="/../public/assets/logo-El-Bayito.png" alt="" width="120px">
            </a>

            <!-- Botón para móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Items del navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-lg-none ms-2">Usuario</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="perfil.php"><i class="bi bi-person me-2"></i> Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="configuracion.php"><i class="bi bi-gear me-2"></i> Configuración</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Overlay para móviles -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="position-sticky pt-3">
            <!-- Menú de navegación -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php" data-page="dashboard">
                        <i class="bi bi-house-door"></i>
                        Dashboard
                    </a>
                </li>
                <?php if($_SESSION['rol'] == '1'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="/usuarios" data-page="usuarios">
                        <i class="bi bi-people"></i>
                        Usuarios
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="/productos" data-page="productos">
                        <i class="bi bi-box"></i>
                        Productos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proveedores" data-page="productos">
                        <i class="bi bi-truck"></i>
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/clientes" data-page="productos">
                        <i class="bi bi-people"></i>
                        Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ventas" data-page="ventas">
                        <i class="bi bi-bag"></i>
                        Ventas
                    </a>
                </li>
                <?php
                if($_SESSION['rol'] == '1'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="/compras" data-page="compras">
                        <i class="bi bi-box-seam"></i>
                        Compras
                    </a>
                </li>
                
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reportes.php" data-page="reportes">
                        <i class="bi bi-file-earmark-text"></i>
                        Reportes
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="configuracion.php" data-page="configuracion">
                        <i class="bi bi-gear"></i>
                        Configuración
                    </a>
                </li>
                <?php } ?>
            </ul>

            <!-- Sección inferior -->
            <hr style="color: rgba(255,255,255,0.2); margin: 20px 0;">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="ayuda.php">
                        <i class="bi bi-question-circle"></i>
                        Ayuda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout">
                        <i class="bi bi-box-arrow-right"></i>
                        Salir
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content" id="mainContent">
        <?= $content ?? '' ?>
    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle del sidebar
            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    // Móviles: mostrar/ocultar con overlay
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                } else {
                    // Desktop: colapsar sidebar
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                }
            });

            // Cerrar sidebar al hacer clic en overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });

            // Gestión de enlaces activos (para cuando uses PHP)
            const currentPage = window.location.pathname.split('/').pop() || 'index.php';
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage) {
                    // Remover active de todos
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Agregar active al actual
                    link.classList.add('active');
                }
            });

            // Cerrar sidebar en móviles al redimensionar ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            });
        });
    </script>
    <!-- Scripts adicionales -->
    <?= $scripts ?? '' ?>
</body>

</html>