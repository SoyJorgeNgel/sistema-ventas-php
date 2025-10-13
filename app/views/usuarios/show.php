<div class="page-header">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h1 class="h3 mb-1" id="pageTitle">Usuarios</h1>
    </div>
    <div class="d-flex gap-2">
      <a type="button" class="btn btn-primary btn-sm" href="/usuarios/crear" role="button">
        <i class="bi bi-plus-lg me-1"></i>
        Nuevo usuario
      </a>
    </div>
  </div>
</div>

<div id="pageContent">
  <div class="card content-card">
    <div class="card-header bg-transparent border-0 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-primary">
          <i class="bi bi-people me-2"></i>
          Tabla usuarios
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
              <th scope="col">Correo</th>
              <th scope="col">Celular</th>
              <th scope="col">Rol</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              foreach ($usuarios as $usuario) {
              ?>
            <tr>
              <th scope="row"><?= $usuario['id'] ?></th>
              <td><?= $usuario['nombre'] ?></td>
              <td><?= $usuario['correo'] ?></td>
              <td><?= $usuario['telefono'] ?></td>
              <td>
                <?php
                if ($usuario['rol'] == 1) { ?>
                  <span class="badge rounded-pill text-bg-primary">Administrador</span>
              </td>
            <?php
                } elseif ($usuario['rol'] == 2) {
            ?>
              <span class="badge rounded-pill text-bg-secondary">Empleado</span></td>
            <?php
                }
            ?>

            <td>
              <div class="d-flex justify-content-center">
                <form action="/usuarios/api/editarUsuario" method="post">
                  <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                  <button
                    type="submit"
                    class="btn btn-info">
                    Editar
                  </button>
                </form>
                <form action="/usuarios/api/desactivarUsuario" method="post">
                  <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                  <button
                    type="submit"
                    class="btn btn-danger ms-2">
                    Eliminar
                  </button>
                </form>
              </div>
            </td>
            </tr>
          <?php
              }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>