<?php
ob_start();
?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Clientes</h1>
        </div>
    </div>
</div>
<div id="pageContent">
    <div class="card border border-3 border-primary">
        <h5 class="card-header bg-primary text-white">Registrar cliente</h5>
        <div class="card-body border border-3 border-primary rounded-bottom">
            <form method="post" action="/clientes/api/crearCliente">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefono</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="522220000">
                </div>
                <div class="d-flex justify-content-end">
                    <input
                        class="btn btn-primary me-2"
                        type="submit"
                        value="Registrar" />
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