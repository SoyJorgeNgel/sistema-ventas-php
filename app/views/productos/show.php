<?php
ob_start();
?>

<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="h3 mb-1" id="pageTitle">Productos</h1>
    </div>
    <?php if ($_SESSION['rol'] == 1): ?>
      <div class="d-flex gap-2">
        <a type="button" class="btn btn-primary btn-sm" href="/productos/crear" role="button">
          <i class="bi bi-plus-lg me-1"></i>
          Nuevo producto
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<div id="pageContent">
  <div class="card content-card">
    <div class="card-header bg-transparent border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-primary">
          <i class="bi bi-box-seam me-2"></i>
          Tabla productos
        </h5>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Descripción</th>
              <th scope="col">Código de barras</th>
              <th scope="col">Precio compra</th>
              <th scope="col">Precio venta</th>
              <th scope="col">Stock</th>
              <th scope="col">Proveedor</th>
              <?php
              if ($_SESSION['rol'] == '1') { ?>
                <th scope="col">Acciones</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <th scope="row"><?= $producto['id'] ?></th>
                <td><?= htmlspecialchars($producto['nombre']) ?></td>
                <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                <td><?= htmlspecialchars($producto['codigo_barras']) ?></td>
                <td>$<?= number_format($producto['precio_compra'], 2) ?></td>
                <td>$<?= number_format($producto['precio_venta'], 2) ?></td>
                <td>
                  <?php if ($producto['stock_total'] > 5): ?>
                    <span class="badge rounded-pill text-bg-success"><?= $producto['stock_total'] ?></span>
                  <?php elseif ($producto['stock_total'] > 0): ?>
                    <span class="badge rounded-pill text-bg-warning"><?= $producto['stock_total'] ?></span>
                  <?php else: ?>
                    <span class="badge rounded-pill text-bg-danger">Sin stock</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($producto['proveedor']) ?></td>
                <?php
                if ($_SESSION['rol'] == 1) :
                ?>
                  <td>
                    <div class="d-flex justify-content-center">
                      <form action="/productos/editarProducto" method="post">
                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                        <button type="submit" class="btn btn-info btn-sm">
                          Editar
                        </button>
                      </form>
                      <form action="/productos/api/desactivarProducto" method="post">
                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm ms-2">
                          Eliminar
                        </button>
                      </form>
                    </div>
                  </td>
                <?php endif ?>

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