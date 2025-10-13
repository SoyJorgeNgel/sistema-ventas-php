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
            <h1 class="h3 mb-1" id="pageTitle">Generar Venta</h1>
        </div>
    </div>
</div>


<!-- 🔹 DATOS DE VENTA -->
<div class="card border border-3 border-primary">
    <h6 class="card-header bg-white text-primary py-2 px-3 border-bottom border-primary">Datos de venta</h6>
    <div class="card-body">
        <div class="row">
            <div class="col-2">
                <label for="id">ID venta</label>
                <input type="number" id="idVenta" class="form-control" disabled>
                <input type="hidden" id="idVendedor" value="<?php echo $_SESSION['id_vendedor'] ?>">
            </div>
            <div class="col-2">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" value="<?= date('Y-m-d') ?>" class="form-control" disabled>
            </div>
            <div class="col-5">
                <label for="cliente">Cliente</label>
                <select id="idCliente" class="form-select">
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- 🔹 AGREGAR PRODUCTO -->
<div class="card border border-3 border-primary my-2">
    <h6 class="card-header bg-white text-primary py-2 px-3 border-bottom border-primary">Ingresar producto</h6>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <label for="cod">Código de barras</label>
                <input type="text" id="cod" class="form-control" placeholder="Código de barras" autofocus>
            </div>
            <div class="col-6">
                <label for="select">Producto</label>
                <select id="mi-select" autocomplete="off">
                    <option value="">Selecciona una opción</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>"
                            data-codigo="<?= $product['codigo_barras'] ?>"
                            data-precio="<?= $product['precio_venta'] ?>"
                            data-stock="<?= $product['stock_total'] ?>">
                            <?= $product['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" min="1">
                <input type="hidden" id="stock">
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-3">
                <label>Precio unitario</label>
                <input type="text" id="uni" class="form-control" disabled>
            </div>
            <div class="col-3">
                <label>Precio total</label>
                <input type="text" id="tot" class="form-control" disabled>
            </div>
            <div class="col-3 d-flex align-items-end">
                <button id="agregar" class="btn btn-primary w-100">Agregar</button>
            </div>
        </div>
    </div>
</div>

<!-- 🔹 TABLA DE PRODUCTOS -->
<div class="card border border-3 border-primary">
    <div class="card-body">
        <table class="table table-striped table-hover table-bordered text-center align-middle" id="tabla-productos">
            <thead class="table-primary">
                <tr>
                    <th>Código de Barras</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot class="table-secondary">
                <tr>
                    <th colspan="4" class="text-end">TOTAL</th>
                    <th id="total-pagar">0.00</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Cantidad entregada</th>
                    <th>
                        <input type="number" class="form-control form-control-sm" id="cantidad-entregada" step="0.01" min="0">
                    </th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Cambio</th>
                    <th id="cambio">0.00</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" id="enviar-venta" disabled>Completar compra</button>
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
    const selectEl = document.getElementById('mi-select');
    const cantidad = document.getElementById('cantidad');
    const precio = document.getElementById('uni');
    const total = document.getElementById('tot');
    const agregar = document.getElementById('agregar');
    const tbody = document.querySelector('#tabla-productos tbody');
    const cantEntregada = document.getElementById('cantidad-entregada');
    const cambio = document.getElementById('cambio');
    const enviarVenta = document.getElementById('enviar-venta');
    const totalPagarEl = document.getElementById('total-pagar');
    const stockInput = document.getElementById('stock');

    // Inicializar TomSelect
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

    //Evento: escribir código de barras
    cod.addEventListener('input', function() {
        let codValue = this.value.trim();
        let opciones = selectEl.options;

        for (let opcion of opciones) {
            if (opcion.dataset.codigo === codValue) {
                select.setValue(opcion.value);
                cantidad.value = 1;
                precio.value = opcion.dataset.precio;
                total.value = (opcion.dataset.precio * cantidad.value).toFixed(2);
                break;
            }
        }
    });

    //Evento: seleccionar producto en el select
    selectEl.addEventListener('change', () => {
        let selectedOption = selectEl.options[selectEl.selectedIndex];
        cod.value = selectedOption.dataset.codigo || "";

        if (selectedOption) {
            precio.value = selectedOption.dataset.precio;
        } else {
            precio.value = "";
        }

        cantidad.value = 1;
        total.value = (precio.value * cantidad.value).toFixed(2);
        stockInput.value = selectedOption.dataset.stock || "";
    });

    //Obtener siguiente ID de venta
    async function obtenerSiguienteId() {
        try {
            const res = await fetch('/ventas/api/obtenerSiguienteId');
            const data = await res.json();
            document.getElementById('idVenta').value = data.nextId;
        } catch (err) {
            console.error('Error al obtener el siguiente ID:', err);
        }
    }

    // Actualizar total al cambiar cantidad
    cantidad.addEventListener('input', () => {
        const p = parseFloat(precio.value) || 0;
        const c = parseFloat(cantidad.value) || 0;
        total.value = (p * c).toFixed(2);
    });

    //Agregar producto a la tabla
    agregar.addEventListener('click', () => {
        if (!selectEl.value || !cantidad.value) {
            alert('Selecciona un producto y cantidad válida');
            return;
        }

        const codigo = cod.value;
        const nombre = selectEl.options[selectEl.selectedIndex].text;
        const precioUnitario = parseFloat(precio.value);
        const cant = parseFloat(cantidad.value);
        const totalFila = (precioUnitario * cant).toFixed(2);
        const idProd = selectEl.value;
        const stockDisponible = stockInput.value;

        if (cant > stockDisponible) {
            alert(`Cantidad solicitada (${cant}) excede el stock disponible (${stockDisponible}).`);
            return;
        }

        fetch('/ventas/api/obtenerStock', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_producto: idProd,
                    cantidad: cant
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Error al obtener el stock:', error);
            });

        // Si ya existe el producto, sumar cantidades
        for (let row of tbody.rows) {
            if (row.cells[0].innerText === codigo) {
                let nuevaCant = parseFloat(row.cells[2].innerText) + cant;
                if (nuevaCant > stockDisponible) {
                    alert(`Cantidad solicitada (${nuevaCant}) excede el stock disponible (${stockDisponible}).`);
                    return;
                }
                row.cells[2].innerText = nuevaCant;
                row.cells[4].innerText = (nuevaCant * precioUnitario).toFixed(2);
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
            <td>${totalFila}</td>
            <td style="display:none;">${idProd}</td>
            <td style="display:none;">${stockDisponible}</td>
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
        select.clear(); //limpia TomSelect correctamente
        cantidad.value = '';
        precio.value = '';
        total.value = '';
        cod.focus();
        cantEntregada.value = '';
        cambio.innerText = '0.00';
    }

    //Calcular total general
    function actualizarTotal() {
        let total = 0;
        for (let row of tbody.rows) {
            total += parseFloat(row.cells[4].innerText) || 0;
        }
        totalPagarEl.innerText = total.toFixed(2);
        validarPago();
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

            // Flag para evitar doble ejecución
            let procesado = false;

            const terminar = () => {
                if (procesado) return; // si ya se ejecutó, no hacer nada
                procesado = true;
                finalizarEdicion(fila, input.value, valorAnterior);
            };

            input.addEventListener('blur', terminar);
            input.addEventListener('keydown', ev => {
                if (ev.key === 'Enter') {
                    input.blur(); // dispara solo un flujo controlado
                }
            });
        }
    });

    function finalizarEdicion(fila, nuevoValor, valorAnterior) {
        const cantidad = parseFloat(nuevoValor) || 1;
        const stockDisponible = parseFloat(fila.cells[6].innerText);

        if (cantidad > stockDisponible) {
            alert(`La cantidad solicitada (${cantidad}) excede el stock disponible (${stockDisponible}).`);
            fila.querySelector('.editable').innerText = valorAnterior;
            return;
        }

        const precio = parseFloat(fila.cells[3].innerText) || 0;
        const total = (cantidad * precio).toFixed(2);

        fila.cells[2].innerText = cantidad;
        fila.cells[4].innerText = total;
        cod.focus();
        actualizarTotal();
    }


    //Calcular cambio y validar botón
    cantEntregada.addEventListener('input', () => {
        const entregado = parseFloat(cantEntregada.value) || 0;
        const total = parseFloat(totalPagarEl.innerText) || 0;
        const dif = entregado - total;
        cambio.innerText = dif.toFixed(2);
        validarPago();
    });

    function validarPago() {
        const entregado = parseFloat(cantEntregada.value) || 0;
        const total = parseFloat(totalPagarEl.innerText) || 0;
        enviarVenta.disabled = entregado < total || total <= 0;
    }

    enviarVenta.addEventListener('click', async () => {
        const idVenta = document.getElementById('idVenta').value;
        const idVendedor = document.getElementById('idVendedor').value;
        const fecha = document.getElementById('fecha').value;
        const idCliente = document.getElementById('idCliente').value;
        const total = totalPagarEl.innerText;

        //Objeto principal de venta
        const venta = {
            id_venta: idVenta,
            id_vendedor: idVendedor,
            fecha,
            id_cliente: idCliente,
            total
        };

        //Construir array con todos los detalles desde la tabla
        const detalles = [];
        for (let row of tbody.rows) {
            detalles.push({
                id_producto: row.cells[5].innerText,
                cantidad: row.cells[2].innerText,
                precioUnitario: row.cells[3].innerText,
                precioTotal: row.cells[4].innerText
            });
        }

        //Crear el cuerpo completo que se enviará al servidor
        const data = {
            venta,
            detalles
        };

        try {
            const response = await fetch('/ventas/api/storeVentaCompleta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert('Venta registrada correctamente');

                //abrir ticket en nueva pestaña
                const ticketUrl = `/ticket?action=ticket_venta&id=${idVenta}`;
                window.open(ticketUrl, '_blank');

                tbody.innerHTML = '';
                actualizarTotal();
                limpiarCampos();
                obtenerSiguienteId();
            } else {
                alert('Error: ' + (result.message || 'No se pudo registrar la venta.'));
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
