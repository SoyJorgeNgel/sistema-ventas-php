<?php
require_once __DIR__ . '/../models/Sales.php';
class SalesController
{

    public function index()
    {
        $title = "Ventas";
        $products = Sales::getProducts();
        $clientes = Sales::getClients();

        require_once __DIR__ . '/../views/ventas/index.php';

        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }

    public function getNextId()
    {
        $nextId = Sales::getNextId();
        echo json_encode(['nextId' => $nextId]);
    }
    public function storeVentaCompleta()
    {
        header('Content-Type: application/json');

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        if (!$data || !isset($data["venta"]) || !isset($data["detalles"])) {
            echo json_encode(["success" => false, "message" => "Datos inválidos o JSON malformado."]);
            return;
        }

        $venta = $data["venta"];
        $detalles = $data["detalles"];

        try {
            $db = Database::connect();
            $db->beginTransaction();

            // Guardar venta
            Sales::storeVentas($db, $venta["id_venta"], $venta["id_vendedor"], $venta["fecha"], $venta["id_cliente"], $venta["total"]);

            // Guardar detalles
            foreach ($detalles as $detalle) {
                Sales::storeDetalles($db, $venta["id_venta"], $detalle["id_producto"], $detalle["cantidad"], $detalle["precioUnitario"], $detalle["precioTotal"]);
            }

            $db->commit();

            echo json_encode(["success" => true, "message" => "Venta y detalles guardados correctamente."]);
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            echo json_encode([
                "success" => false,
                "message" => "Error al guardar los datos.",
                "error" => $e->getMessage()
            ]);
        }
    }


    /*public function storeVentas()
    {
        $json_data = file_get_contents("php://input");

        // Decodificar el JSON a un array asociativo en PHP
        $data = json_decode($json_data, true);

        if ($data) {
            $idVenta = $data["id_venta"];
            $idVendedor = $data["id_vendedor"];
            $fecha = $data["fecha"];
            $idCliente = $data["id_cliente"];
            $total = $data["total"];
            $stmt = Sales::storeVentas($idVenta, $idVendedor, $fecha, $idCliente, $total);

        } else {
            //AQUI DEBERIA MANDAR INFORMACION PARA LA ALERTA
            echo "Error al decodificar JSON o datos no recibidos.";
        }
    }
    public function storeDetalles() {
        $json_data = file_get_contents("php://input");

        // Decodificar el JSON a un array asociativo en PHP
        $data = json_decode($json_data, true);

        if ($data) {
            $idVenta = $data["id_venta"];
            $idProducto = $data["id_producto"];
            $cantidad = $data["cantidad"];
            $precioUnitario = $data["precioUnitario"];
            $precioTotal = $data["precioTotal"];

            $stmt = Sales::storeDetalles($idVenta, $idProducto, $cantidad, $precioUnitario, $precioTotal);
        } else {
            echo "Error al decodificar JSON o datos no recibidos.";
        }
    }*/
        public function getStock() {
            header('Content-Type: application/json');
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);
            $stmt = Sales::getStock($data['id_producto'], $data['cantidad']);
            echo json_encode($stmt);
        }  
            
}
