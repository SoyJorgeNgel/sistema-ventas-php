<?php
require_once __DIR__ . '/../../libraries/dompdf/autoload.inc.php';
require_once __DIR__ . '/../../core/Database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsController
{
    public function generarTicketVenta($idVenta)
    {
        try {
            $db = Database::connect();
            $datosVenta = $this->obtenerDatosVenta($db, $idVenta);

            if (!$datosVenta) {
                throw new Exception("Venta no encontrada");
            }

            $this->generarPDF($datosVenta);
        } catch (Exception $e) {
            echo "Error al generar el ticket: " . $e->getMessage();
        }
    }

    private function obtenerDatosVenta($db, $idVenta)
    {
        $sqlVenta = "
            SELECT 
                v.id,
                v.fecha,
                v.total,
                COALESCE(c.nombre, 'Cliente General') as cliente_nombre,
                c.telefono as cliente_telefono,
                COALESCE(u.nombre, 'Sistema') as vendedor_nombre
            FROM ventas v
            LEFT JOIN clientes c ON v.id_cliente = c.id
            LEFT JOIN usuarios u ON v.id_vendedor = u.id
            WHERE v.id = ?
        ";

        $stmt = $db->prepare($sqlVenta);
        $stmt->execute([$idVenta]);
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$venta) return null;

        $sqlDetalles = "
            SELECT 
                dv.cantidad,
                dv.precio_unitario,
                dv.total,
                p.nombre as producto_nombre,
                COALESCE(p.codigo_barras, '') as codigo_barras
            FROM detalle_ventas dv
            INNER JOIN productos p ON dv.id_producto = p.id
            WHERE dv.id_venta = ?
            ORDER BY p.nombre
        ";

        $stmt = $db->prepare($sqlDetalles);
        $stmt->execute([$idVenta]);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'venta' => $venta,
            'detalles' => $detalles
        ];
    }

    private function generarPDF($datos)
    {
        // Configurar DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        // Calcular altura aproximada basada en contenido
        $alturaCalculada = $this->calcularAlturaTicket($datos);

        // Generar HTML del ticket
        $html = $this->generarHTMLTicket($datos);

        // Cargar HTML
        $dompdf->loadHtml($html);

        // Configurar papel con altura calculada (80mm ancho)
        $dompdf->setPaper([0, 0, 226.77, $alturaCalculada], 'portrait');

        // Renderizar PDF
        $dompdf->render();

        // Enviar al navegador
        $nombreArchivo = 'ticket_venta_' . $datos['venta']['id'] . '.pdf';
        $dompdf->stream($nombreArchivo, ['Attachment' => false]);
    }

    private function calcularAlturaTicket($datos)
    {
        $venta = $datos['venta'];
        $detalles = $datos['detalles'];

        // Altura base del ticket (encabezado, info, pie)
        $alturaBase = 200; // ~70mm en puntos

        // Altura por cada producto (incluyendo código de barras si existe)
        $alturaPorProducto = 15; // ~5mm por producto
        $alturaCodigoBarras = 8; // ~3mm adicional si tiene código

        $alturaProductos = 0;
        foreach ($detalles as $detalle) {
            $alturaProductos += $alturaPorProducto;

            // Si tiene código de barras, agregar altura extra
            if (!empty($detalle['codigo_barras'])) {
                $alturaProductos += $alturaCodigoBarras;
            }

            // Si el nombre del producto es muy largo, agregar altura extra
            if (strlen($detalle['producto_nombre']) > 25) {
                $alturaProductos += 10; // Altura extra para nombres largos
            }
        }

        // Altura para información del cliente (si existe)
        $alturaCliente = 0;
        if ($venta['cliente_nombre'] && $venta['cliente_nombre'] !== 'Cliente General') {
            $alturaCliente = 20; // ~7mm
            if ($venta['cliente_telefono']) {
                $alturaCliente += 10; // ~3.5mm adicional
            }
        }

        // Calcular altura total
        $alturaTotal = $alturaBase + $alturaProductos + $alturaCliente;

        // Agregar margen de seguridad
        $alturaTotal += 60; // ~14mm de margen

        return $alturaTotal;
    }


    private function generarHTMLTicket($datos)
    {
        $venta = $datos['venta'];
        $detalles = $datos['detalles'];
        $fechaFormateada = date('d/m/Y H:i', strtotime($venta['fecha']));

        $filasProductos = '';
        foreach ($detalles as $detalle) {
            $filasProductos .= '
                <tr>
                    <td class="prod-nombre">
                        ' . htmlspecialchars($detalle['producto_nombre']) . '
                        ' . (!empty($detalle['codigo_barras']) ? '<br><small class="codigo">Cód: ' . $detalle['codigo_barras'] . '</small>' : '') . '
                    </td>
                    <td class="prod-cant">' . number_format($detalle['cantidad'], 1) . '</td>
                    <td class="prod-precio">$' . number_format($detalle['precio_unitario'], 2) . '</td>
                    <td class="prod-total">$' . number_format($detalle['total'], 2) . '</td>
                </tr>';
        }

        $clienteInfo = '';
        if ($venta['cliente_nombre'] && $venta['cliente_nombre'] !== 'Cliente General') {
            $clienteInfo = '<p>Cliente: ' . htmlspecialchars($venta['cliente_nombre']) . '</p>';
            if ($venta['cliente_telefono']) {
                $clienteInfo .= '<p>Tel: ' . htmlspecialchars($venta['cliente_telefono']) . '</p>';
            }
        }
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/public/assets/logo-negro-El-Bayito.png';
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);

        $srclogo = 'data:image/' . $imageType . ';base64,' . $imageData;

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Ticket de Venta #' . $venta['id'] . '</title>
            <style>
                * {
                    box-sizing: border-box;
                }
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 5px 5px;
                    font-size: 10px;
                    width: 100%;
                }
                .header {
                    text-align: center;
                    margin-bottom: 10px;
                    border-bottom: 1px solid #000;
                    padding-bottom: 5px;
                }
                .company-logo {
                    width: 60%;
                    height: 20px;
                    margin-bottom: 5px;
                }
                .company-name {
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                }
                .company-info {
                    font-size: 8px;
                    line-height: 1.2;
                    margin: 3px 0 0;
                }
                .ticket-info {
                    text-align: left;
                    font-size: 9px;
                    margin-top: 8px;
                }
                .ticket-info p {
                    margin: 2px 0;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                th, td {
                    font-size: 9px;
                    padding: 2px 0;
                    vertical-align: top;
                }
                thead th {
                    border-top: 1px solid #000;
                    border-bottom: 1px solid #000;
                }
                .prod-nombre { text-align: left; width: 45%; }
                .prod-cant { text-align: center; width: 15%; }
                .prod-precio { text-align: right; width: 20%; }
                .prod-total { text-align: right; width: 20%; font-weight: bold; }
                tbody tr td {
                    border-bottom: 1px dotted #ccc;
                }
                .codigo {
                    font-size: 7px;
                    color: #555;
                }
                .total-section {
                    border-top: 1px solid #000;
                    margin-top: 10px;
                    padding-top: 5px;
                    text-align: right;
                    font-size: 12px;
                    font-weight: bold;
                }
                .footer {
                    text-align: center;
                    margin-top: 15px;
                    border-top: 1px dotted #000;
                    padding-top: 5px;
                    font-size: 8px;
                }
            </style>
        </head>
        <body>
            <div class="header">
            <div class="company-name">
                <img src="' . $srclogo . '" alt="Logo" style="max-width: 100%; height: 40px;">
            </div>
            <div class="company-info">
                    Calle Ejemplo #123<br>
                    Col. Centro<br>
                    Tel: (555) 123-4567<br>
                    RFC: EMPRESA123456ABC
                </div>
            </div>

            <div class="ticket-info">
                <p><strong>Folio:</strong> ' . str_pad($venta['id'], 6, '0', STR_PAD_LEFT) . '</p>
                <p><strong>Fecha:</strong> ' . $fechaFormateada . '</p>
                <p><strong>Vendedor:</strong> ' . htmlspecialchars($venta['vendedor_nombre']) . '</p>
                ' . $clienteInfo . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th>PRODUCTO</th>
                        <th>CANT</th>
                        <th>PRECIO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>' . $filasProductos . '</tbody>
            </table>

            <div class="total-section">
                TOTAL A PAGAR: $' . number_format($venta['total'], 2) . '
            </div>

            <div class="footer">
                ¡Gracias por su preferencia!<br>
                Conserve su ticket<br>
                <small>Generado: ' . date('d/m/Y H:i:s') . '</small><br>
                <small>Sistema de Ventas v1.0</small>
            </div>
        </body>
        </html>';
    }
}
