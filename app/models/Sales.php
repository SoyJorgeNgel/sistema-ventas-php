<?php
require_once __DIR__ . '/../../core/Database.php';

class Sales
{
    // Propiedad estática para almacenar la conexión PDO
    private static $db = null;
    // Método interno para obtener la conexión
    private static function connect()
    {
        if (!self::$db) {
            self::$db = Database::connect();
        }
        return self::$db;
    }
    // Traer todos los productos activos
    public static function getProducts()
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM productos WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getClients()
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getNextId()
    {
        $db = self::connect();
        $stmt = $db->query("SELECT id FROM ventas ORDER BY id DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['id'] + 1;
        } else {
            return 1; //Si no hay registros, el próximo ID es 1
        }
    }

    public static function storeVentas($db, $idVenta, $idVendedor, $fecha, $idCliente, $total)
    {
        $stmt = $db->prepare("
        INSERT INTO ventas (id, id_cliente, id_vendedor, fecha, total)
        VALUES (:idVenta, :idCliente, :idVendedor, :fecha, :total)
    ");
        $stmt->execute([
            ':idVenta'    => $idVenta,
            ':idCliente'  => $idCliente,
            ':idVendedor' => $idVendedor,
            ':fecha'      => $fecha,
            ':total'      => $total
        ]);
    }

    public static function storeDetalles($db, $idVenta, $idProducto, $cantidad, $precioUnitario, $precioTotal)
    {
        $stmt = $db->prepare("
        INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, total)
        VALUES (:idVenta, :idProducto, :cantidad, :precioUnitario, :precioTotal)
    ");
        $stmt->execute([
            ':idVenta'        => $idVenta,
            ':idProducto'     => $idProducto,
            ':cantidad'       => $cantidad,
            ':precioUnitario' => $precioUnitario,
            ':precioTotal'    => $precioTotal
        ]);

        $stmtUpdate = $db->prepare("
        UPDATE productos
        SET stock_total = stock_total - :cantidad
        WHERE id = :idProducto
    ");
        $stmtUpdate->execute([
            ':cantidad'   => $cantidad,
            ':idProducto' => $idProducto
        ]);
    }

    public static function getStock($idProducto, $cantidad)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT stock_total - :cantidad AS nuevo_stock_total FROM productos WHERE id = :idProducto;");
        $stmt->execute([
            ':idProducto' => $idProducto,
            ':cantidad'   => $cantidad
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
