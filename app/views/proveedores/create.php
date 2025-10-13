<?php
ob_start();
?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Proveedores</h1>
        </div>
    </div>
</div>
<div id="pageContent">
    <div class="card border">
        <h5 class="card-header bg-primary text-white d-flex align-items-center">
            <i class='bx bxs-user-plus me-2'></i>
            Nuevo proveedor
        </h5>
        <div class="card-body border border-3 border-primary rounded-bottom">
            <form method="post" action="/proveedor/api/crearProveedor">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contacto</label>
                    <input type="text" class="form-control" id="contact" name="contact" placeholder="ej. num telefonico o correo electronico">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefono</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="522220000">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com">
                </div>
                <div class="d-flex justify-content-end">
                    <input
                        class="btn btn-primary me-2"
                        type="submit"
                        value="Registrar" />
                    <a
                        class="btn btn-danger"
                        href="/proveedores"
                        role="button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
?>