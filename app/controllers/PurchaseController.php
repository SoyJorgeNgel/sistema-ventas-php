<?php
require_once __DIR__ . '/../models/Purchases.php';
require_once __DIR__ . '/../models/Providers.php';

class PurchaseController
{
    public function index()
    {
        $title = "Compras";
        //los productos del modelo de ventas(sales) para no duplicar codigo
        $products = Purchases::getProducts();
        $proveedores = Purchases::allProviders();
        require_once __DIR__ . '/../views/compras/index.php';
        require_once __DIR__ . '/../views/layouts/sidebar-navbar.php';
    }
    public function getNextId()
    {
        $nextId = Purchases::getNextId();
        echo json_encode(['nextId' => $nextId]);
    }
    public function getProductsByProvider()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['id_proveedor'])) {
            echo json_encode(['error' => 'ID de proveedor no recibido']);
            return;
        }

        $id_proveedor = (int) $data['id_proveedor'];
        $products = Purchases::allProductProvider($id_proveedor);

        echo json_encode(['productos' => $products]);
    }

    public function storeCompraCompleta()
{
    header('Content-Type: application/json');

    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if (!$data || !isset($data["compra"]) || !isset($data["detalles"])) {
        echo json_encode(["success" => false, "message" => "Datos inválidos o JSON malformado."]);
        return;
    }

    $compra = $data["compra"];
    $detalles = $data["detalles"];

    try {
        $db = Database::connect();
        $db->beginTransaction();

        // Guardar compra principal
        Purchases::storeCompra(
            $db, 
            $compra["id_compra"], 
            $compra["id_usuario"], 
            $compra["id_proveedor"], 
            $compra["fecha"], 
            $compra["total"]
        );

        // Guardar detalles de compra
        foreach ($detalles as $detalle) {
            Purchases::storeDetalleCompra(
                $db, 
                $compra["id_compra"], 
                $detalle["id_producto"], 
                $detalle["cantidad"], 
                $detalle["precio_unitario"], 
                $detalle["descuento"], 
                $detalle["precio_final"], 
                $detalle["precio_total"]
            );
        }

        $db->commit();

        echo json_encode(["success" => true, "message" => "Compra y detalles guardados correctamente."]);
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

}
