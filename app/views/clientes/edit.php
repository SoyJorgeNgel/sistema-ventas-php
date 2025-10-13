<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Clientes</h1>
        </div>
    </div>
</div>
<div id="pageContent">
    <div class="card border">
        <h5 class="card-header bg-primary text-white d-flex align-items-center">
            <i class='bx bxs-user-plus me-2'></i>
            Editar clientes
        </h5>
        <div class="card-body border border-3 border-primary rounded-bottom">
            <form method="post" action="/clientes/api/actualizar">
                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $client['nombre'] ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefono</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= $client['telefono'] ?>">
                </div>
                <div class="d-flex justify-content-end">
                    <input
                        class="btn btn-primary me-2"
                        type="submit"
                        value="Actualizar" />
                    <a
                        class="btn btn-danger"
                        href="/clientes"
                        role="button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
?>  