<?php
date_default_timezone_set('America/Mexico_City');

ob_start();
?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<?php
$head = ob_get_clean();
?>

<?php
ob_start();
?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1" id="pageTitle">Registrar Compra</h1>
        </div>
    </div>
</div>

<!-- DATOS DE COMPRA -->
<div class="card border border-3 border-success">
    <h6 class="card-header bg-white text-success py-2 px-3 border-bottom border-success">Datos de compra</h6>
    <div class="card-body">
        <div class="row">
            <div class="col-2">
                <label for="id">ID compra</label>
                <input type="number" id="idCompra" class="form-control" disabled>
                <input type="hidden" id="idUsuario" value="<?php echo $_SESSION['id_vendedor'] ?>">
            </div>
            <div class="col-2">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" value="<?= date('Y-m-d') ?>" class="form-control" disabled>
            </div>
            <div class="col-4">
                <label for="usuario">Registrado por: </label>
                <input type="text" class="form-control" value="<?= $_SESSION['nombre'] ?>" disabled>
            </div>
            <div class="col-4">
                <label for="proveedor">Proveedor</label>
                <select id="select-proveedor" autocomplete="off" required>
                    <option value="">Selecciona un proveedor</option>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option value="<?= $proveedor['id'] ?>">
                            <?= $proveedor['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- AGREGAR PRODUCTO -->
<div class="card border border-3 border-success my-2">
    <h6 class="card-header bg-white text-success py-2 px-3 border-bottom border-success">Ingresar producto</h6>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <label for="cod">Código de barras</label>
                <input type="text" id="cod" class="form-control" placeholder="Código de barras" autofocus disabled>
            </div>
            <div class="col-6">
                <label for="select">Producto</label>
                <select id="mi-select" autocomplete="off" disabled>
                    <option value="">Primero selecciona un proveedor</option>
                </select>
            </div>
            <div class="col-3">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" min="1" disabled>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-3">
                <label>Precio de compra</label>
                <input type="number" id="precio" class="form-control" step="0.01" min="0" disabled>
            </div>
            <div class="col-3">
                <label>% Descuento</label>
                <input type="number" id="descuento" class="form-control" step="0.01" min="0" max="100" placeholder="0" disabled>
            </div>
            <div class="col-3">
                <label>Precio final</label>
                <input type="number" id="precio-final" class="form-control" step="0.01" disabled readonly>
            </div>
            <div class="col-3 d-flex align-items-end">
                <button id="agregar" class="btn btn-success w-100" disabled>Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- TABLA DE PRODUCTOS -->
<div class="card border border-3 border-success">
    <div class="card-body">
        <table class="table table-striped table-hover table-bordered text-center align-middle" id="tabla-productos">
            <thead class="table-success">
                <tr>
                    <th>Código de Barras</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>% Descuento</th>
                    <th>Precio Final</th>
                    <th>Precio Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot class="table-secondary">
                <tr>
                    <th colspan="6" class="text-end">TOTAL</th>
                    <th id="total-pagar">0.00</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-success" id="enviar-compra" disabled>Completar compra</button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
?>

<?php
ob_start();
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        obtenerSiguienteId();
    });

    const cod = document.getElementById('cod');
    const selectProveedorEl = document.getElementById('select-proveedor');
    const selectEl = document.getElementById('mi-select');
    const cantidad = document.getElementById('cantidad');
    const precio = document.getElementById('precio');
    const descuento = document.getElementById('descuento');
    const precioFinal = document.getElementById('precio-final');
    const agregar = document.getElementById('agregar');
    const tbody = document.querySelector('#tabla-productos tbody');
    const enviarCompra = document.getElementById('enviar-compra');
    const totalPagarEl = document.getElementById('total-pagar');

    // Inicializar TomSelect para proveedor
    const selectProveedor = new TomSelect(selectProveedorEl, {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        valueField: "value",
        labelField: "text",
        searchField: "text"
    });

    // Inicializar TomSelect para productos
    const select = new TomSelect(selectEl, {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        valueField: "value",
        labelField: "text",
        searchField: "text"
    });

    // Evento: seleccionar proveedor
    selectProveedorEl.addEventListener('change', async () => {
        const proveedorId = selectProveedorEl.value;

        if (proveedorId) {
            await cargarProductosDelProveedor(proveedorId);
            habilitarCampos();
        } else {
            deshabilitarCampos();
            select.clear();
            select.clearOptions();
            select.addOption({
                value: "",
                text: "Primero selecciona un proveedor"
            });
        }
    });

    // Cargar productos del proveedor seleccionado
    async function cargarProductosDelProveedor(proveedorId) {
        try {
            const response = await fetch('/compras/api/obtenerProductosProveedor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_proveedor: proveedorId
                })
            });

            const data = await response.json();

            // Limpiar opciones actuales
            select.clear();
            select.clearOptions();

            // Agregar productos del proveedor
            data.productos.forEach(producto => {
                select.addOption({
                    value: producto.id,
                    text: producto.nombre,
                    codigo: producto.codigo_barras,
                    precio: producto.precio_compra
                });
            });

        } catch (error) {
            console.error('Error al cargar productos del proveedor:', error);
            alert('Error al cargar los productos del proveedor');
        }
    }

    function habilitarCampos() {
        cod.disabled = false;
        if (selectEl.tomselect) {
            selectEl.tomselect.enable(); // habilita visualmente Tom Select
        }
        cantidad.disabled = false;
        precio.disabled = false;
        descuento.disabled = false;
        agregar.disabled = false;
    }

    function deshabilitarCampos() {
        cod.disabled = true;
        if (selectEl.tomselect) {
            selectEl.tomselect.disable(); // deshabilita visualmente Tom Select
        }
        cantidad.disabled = true;
        precio.disabled = true;
        descuento.disabled = true;
        precioFinal.disabled = true;
        agregar.disabled = true;
    }

    // Evento: escribir código de barras
    cod.addEventListener('input', function() {
        let codValue = this.value.trim();
        let opciones = select.options;

        for (let [key, opcion] of Object.entries(opciones)) {
            if (opcion.codigo === codValue) {
                select.setValue(opcion.value);
                cantidad.value = 1;
                precio.value = opcion.precio;
                descuento.value = 0;
                calcularPrecioFinal();
                break;
            }
        }
    });

    // Evento: seleccionar producto en el select
    selectEl.addEventListener('change', () => {
        const selectedValue = selectEl.value;
        if (selectedValue) {
            const opcion = select.options[selectedValue];
            cod.value = opcion.codigo || "";
            precio.value = opcion.precio || "";
            cantidad.value = 1;
            descuento.value = 0;
            calcularPrecioFinal();
        } else {
            cod.value = "";
            precio.value = "";
            cantidad.value = "";
            descuento.value = "";
            precioFinal.value = "";
        }
    });

    // Calcular precio final con descuento
    function calcularPrecioFinal() {
        const precioBase = parseFloat(precio.value) || 0;
        const porcentajeDescuento = parseFloat(descuento.value) || 0;
        const descuentoDecimal = porcentajeDescuento / 100;
        const precioConDescuento = precioBase * (1 - descuentoDecimal);
        precioFinal.value = precioConDescuento.toFixed(2);
    }

    // Eventos para recalcular precio final
    precio.addEventListener('input', calcularPrecioFinal);
    descuento.addEventListener('input', calcularPrecioFinal);

    // Obtener siguiente ID de compra
    async function obtenerSiguienteId() {
        try {
            const res = await fetch('/compras/api/obtenerSiguienteId');
            const data = await res.json();
            document.getElementById('idCompra').value = data.nextId;
        } catch (err) {
            console.error('Error al obtener el siguiente ID:', err);
        }
    }

    // Agregar producto a la tabla
    agregar.addEventListener('click', () => {
        if (!selectProveedorEl.value) {
            alert('Selecciona un proveedor primero');
            return;
        }

        if (!selectEl.value || !cantidad.value || !precio.value) {
            alert('Completa todos los campos requeridos');
            return;
        }

        const codigo = cod.value;
        const nombre = select.options[selectEl.value].text;
        const precioUnitario = parseFloat(precio.value);
        const cant = parseFloat(cantidad.value);
        const porcentajeDescuento = parseFloat(descuento.value) || 0;
        const precioFinalUnitario = parseFloat(precioFinal.value);
        const totalFila = (precioFinalUnitario * cant).toFixed(2);
        const idProd = selectEl.value;

        // Si ya existe el producto, sumar cantidades
        for (let row of tbody.rows) {
            if (row.cells[0].innerText === codigo) {
                let nuevaCant = parseFloat(row.cells[2].innerText) + cant;
                row.cells[2].innerText = nuevaCant;
                row.cells[6].innerText = (nuevaCant * precioFinalUnitario).toFixed(2);
                actualizarTotal();
                limpiarCampos();
                return;
            }
        }

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${codigo}</td>
            <td>${nombre}</td>
            <td class="editable">${cant}</td>
            <td>${precioUnitario.toFixed(2)}</td>
            <td>${porcentajeDescuento.toFixed(2)}%</td>
            <td>${precioFinalUnitario.toFixed(2)}</td>
            <td>${totalFila}</td>
            <td style="display:none;">${idProd}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-editar">Editar</button>
                <button class="btn btn-sm btn-danger btn-eliminar">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);

        limpiarCampos();
        actualizarTotal();
    });

    function limpiarCampos() {
        cod.value = '';
        select.clear();
        cantidad.value = '';
        precio.value = '';
        descuento.value = '';
        precioFinal.value = '';
        cod.focus();
    }

    // Calcular total general
    function actualizarTotal() {
        let total = 0;
        for (let row of tbody.rows) {
            total += parseFloat(row.cells[6].innerText) || 0;
        }
        totalPagarEl.innerText = total.toFixed(2);
        enviarCompra.disabled = total <= 0;
    }

    // Delegación de eventos (editar / eliminar)
    document.addEventListener('click', (e) => {
        const btn = e.target;

        if (btn.classList.contains('btn-eliminar')) {
            btn.closest('tr').remove();
            actualizarTotal();
        }

        if (btn.classList.contains('btn-editar')) {
            const fila = btn.closest('tr');
            const celda = fila.querySelector('.editable');
            const valorAnterior = celda.innerText.trim();

            celda.innerHTML = `<input type="number" class="form-control form-control-sm" min="1" value="${valorAnterior}">`;
            const input = celda.querySelector('input');
            input.focus();

            let procesado = false;

            const terminar = () => {
                if (procesado) return;
                procesado = true;
                finalizarEdicion(fila, input.value, valorAnterior);
            };

            input.addEventListener('blur', terminar);
            input.addEventListener('keydown', ev => {
                if (ev.key === 'Enter') {
                    input.blur();
                }
            });
        }
    });

    function finalizarEdicion(fila, nuevoValor, valorAnterior) {
        const cantidad = parseFloat(nuevoValor) || 1;
        const precioFinal = parseFloat(fila.cells[5].innerText) || 0;
        const total = (cantidad * precioFinal).toFixed(2);

        fila.cells[2].innerText = cantidad;
        fila.cells[6].innerText = total;
        cod.focus();
        actualizarTotal();
    }

    enviarCompra.addEventListener('click', async () => {
        if (!selectProveedorEl.value) {
            alert('Selecciona un proveedor');
            return;
        }

        const idCompra = document.getElementById('idCompra').value;
        const idUsuario = document.getElementById('idUsuario').value;
        const idProveedor = selectProveedorEl.value;
        const fecha = document.getElementById('fecha').value;
        const total = totalPagarEl.innerText;

        // Objeto principal de compra
        const compra = {
            id_compra: idCompra,
            id_usuario: idUsuario,
            id_proveedor: idProveedor,
            fecha,
            total
        };

        // Construir array con todos los detalles desde la tabla
        const detalles = [];
        for (let row of tbody.rows) {
            detalles.push({
                id_producto: row.cells[7].innerText,
                cantidad: row.cells[2].innerText,
                precio_unitario: row.cells[3].innerText,
                descuento: parseFloat(row.cells[4].innerText.replace('%', '')),
                precio_final: row.cells[5].innerText,
                precio_total: row.cells[6].innerText
            });
        }

        // Crear el cuerpo completo que se enviará al servidor
        const data = {
            compra,
            detalles
        };

        try {
            const response = await fetch('/compras/api/storeCompraCompleta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert('Compra registrada correctamente');
                tbody.innerHTML = '';
                actualizarTotal();
                limpiarCampos();
                selectProveedor.clear();
                deshabilitarCampos();
                obtenerSiguienteId();
            } else {
                alert('Error: ' + (result.message || 'No se pudo registrar la compra.'));
                console.error(result.error);
            }
        } catch (error) {
            console.error('Error en la petición:', error);
            alert('Error al conectar con el servidor.');
        }
    });
</script>
<?php
$scripts = ob_get_clean();
?>