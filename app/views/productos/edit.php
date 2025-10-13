<?php
ob_start();
?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Productos</h1>
        </div>
    </div>
</div>

<div class="card border">
    <h5 class="card-header bg-primary text-white d-flex align-items-center">
        <i class='bx bxs-user-plus me-2'></i>
        Editar producto
    </h5>
    <div class="card-body border border-3 border-primary rounded-bottom">
        <form method="post" action="/productos/api/actualizarProducto">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="desc" name="desc" value="<?= $producto['descripcion'] ?>">
            </div>
            <div class="mb-3">
                <label for="cod" class="form-label">Codigo de barras</label>
                <input type="text" class="form-control" id="cod" name="cod" value="<?= $producto['codigo_barras'] ?>">
            </div>
            <div class="mb-3">
                <label for="compra" class="form-label">Precio compra</label>
                <input type="decimal" class="form-control" id="compra" name="compra" value="<?= $producto['precio_compra'] ?>">
            </div>
            <div class="mb-3">
                <label for="venta" class="form-label">Precio venta</label>
                <input type="decimal" class="form-control" id="venta" name="venta" value="<?= $producto['precio_venta'] ?>">
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="decimal" class="form-control" id="stock" name="stock" value="<?= $producto['stock_total'] ?>">
            </div>
            <div class="mb-3">
                <label for="prov" class="form-label">Proveedor</label>
                <select class="form-select" name="prov" id="prov" required>
                    <option value="">Selecciona un proveedor</option>
                    <?php
                    foreach ($proveedores as $proveedor) {
                    ?>
                        <option <?= $producto['id_proveedor'] == $proveedor['id'] ? 'selected' : '' ?> value="<?= $proveedor['id'] ?>"><?= $proveedor['nombre'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-end">
                <input
                    class="btn btn-primary me-2"
                    type="submit"
                    value="Actualizar" />
                <a
                    class="btn btn-danger"
                    href="/proveedores"
                    role="button">Cancelar</a>
            </div>
        </form>
    </div>
</div>


<?php
$content = ob_get_clean();
?>