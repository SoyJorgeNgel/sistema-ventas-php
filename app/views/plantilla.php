<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menú Lateral con Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="/public/css/menu..css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

  <!-- Checkbox -->
  <input type="checkbox" id="menu-toggle" />

  <!-- Navbar -->
  <div class="navbar">
    <label for="menu-toggle" class="menu-icon">
      <span></span>
      <span></span>
      <span></span>
    </label>
    <h1>Mi Sitio</h1>
  </div>

  <!-- Menú lateral -->
  <nav class="side-menu">
    <a href="#">Inicio</a>
    <a href="#">Productos</a>
    <a href="#">Servicios</a>
    <a href="#">Contacto</a>
  </nav>

  <!-- Contenido -->
  <div class="content">
    <h2>Bienvenido</h2>
    <p>Este es el contenido de tu página.</p>
  </div>
</body>

</html>