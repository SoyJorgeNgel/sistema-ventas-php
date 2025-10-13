<?php
ob_start();
?>
<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="h3 mb-1" id="pageTitle">Proveedores</h1>
    </div>
    <?php if ($_SESSION['rol'] == '1') : ?>
      <div class="d-flex gap-2">
        <a type="button" class="btn btn-primary btn-sm" href="/proveedores/crear" role="button">
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo proveedor
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>
<div id="pageContent">
  <div class="card content-card">
    <div class="card-header bg-transparent border-0 py-3">
      <h5 class="card-title mb-0 text-primary">
        <i class="bi bi-truck"></i>
        Tabla proveedores
      </h5>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Contacto</th>
              <th scope="col">Telefono</th>
              <th scope="col">Correo</th>
              <?php if ($_SESSION['rol'] == '1') : ?>
              <th scope="col">Acciones</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($proveedores as $proveedor): ?>
              <tr>
                <th scope="row"><?= htmlspecialchars($proveedor['id']) ?></th>
                <td><?= htmlspecialchars($proveedor['nombre']) ?></td>
                <td><?= htmlspecialchars($proveedor['contacto']) ?></td>
                <td><?= htmlspecialchars($proveedor['telefono']) ?></td>
                <td><?= htmlspecialchars($proveedor['correo']) ?></td>
                <?php if ($_SESSION['rol'] == '1') : ?>

                <td>
                  <div class="d-flex justify-content-center">
                    <form action="/proveedores/editarProveedor" method="post">
                      <input type="hidden" name="id" value="<?= $proveedor['id'] ?>">
                      <button type="submit" class="btn btn-info btn-sm">Editar</button>
                    </form>
                    <form action="/proveedores/api/desactivarProveedor" method="post" class="ms-2">
                      <input type="hidden" name="id" value="<?= $proveedor['id'] ?>">
                      <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                  </div>
                </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
?>