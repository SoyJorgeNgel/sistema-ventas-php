<?php
ob_start();
?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Clientes</h1>
        </div>
        <div class="d-flex gap-2">
            <a type="button" class="btn btn-primary btn-sm" href="/clientes/crear" role="button">
                <i class="bi bi-plus-lg me-1"></i>
                Nuevo cliente
            </a>
        </div>
    </div>
</div>
<div id="pageContent">
    <div class="card content-card">
        <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 text-primary">
                <i class="bi bi-people me-2"></i>
                Tabla clientes
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Telefono</th>
                            <th class="d-flex justify-content-center" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <?php if ($cliente['id'] == 1 && $_SESSION['rol'] == 1 || $cliente['id'] != 1): ?>
                                <tr>
                                    <th scope="row"><?= $cliente['id'] ?></th>
                                    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <form action="/clientes/editar" method="post">
                                                <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
                                                <button type="submit" class="btn btn-info btn-sm">
                                                    Editar
                                                </button>
                                            </form>
                                            <?php if ($_SESSION['rol'] == '1') : ?>
                                                <form action="/clientes/api/desactivar" method="post" class="ms-2">
                                                    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

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