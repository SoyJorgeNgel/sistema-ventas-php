<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Usuarios</h1>
        </div>
    </div>
</div>

<div id="pageContent">
    <div class="card border">
        <h5 class="card-header bg-primary text-white d-flex align-items-center">
            <i class='bx bxs-user-plus me-2'></i>
            Nuevo usuario
        </h5>
        <div class="card-body border border-3 border-primary rounded-bottom">
            <form method="post" action="/usuarios/api/crearUsuario">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Celular</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="522220000">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="******" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select class="form-select" name="role" id="role">
                        <option value="">Selecciona un rol</option>
                        <option value="1">Administrador</option>
                        <option value="2">Empleado</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <input
                        class="btn btn-primary me-2"
                        type="submit"
                        value="Registrar" />
                    <a
                        class="btn btn-danger"
                        href="/usuarios"
                        role="button">Cancelar</a>

                </div>
            </form>
        </div>
    </div>
</div>