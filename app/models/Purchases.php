<?php
require_once __DIR__ . '/../../core/Database.php';

class Purchases
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
    public static function getNextId()
    {
        $db = self::connect();
        $stmt = $db->query("SELECT id FROM compras ORDER BY id DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['id'] + 1;
        } else {
            return 1; //Si no hay registros, el próximo ID es 1
        }
    }
    public static function getProducts()
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM productos WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allProviders()
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM proveedores WHERE estado != 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function allProductProvider($id_proveedor)
    {
        $db = self::connect();
        $stmt = $db->prepare("SELECT * FROM productos WHERE id_proveedor = ? AND estado != 0;");
        $stmt->execute([$id_proveedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function storeCompra($db, $idCompra, $idUsuario, $idProveedor, $fecha, $total)
    {
        $stmt = $db->prepare("
            INSERT INTO compras (id, id_usuario, id_proveedor, fecha, total)
            VALUES (:idCompra, :idUsuario, :idProveedor, :fecha, :total)
        ");
        $stmt->execute([
            ':idCompra'    => $idCompra,
            ':idUsuario'   => $idUsuario,
            ':idProveedor' => $idProveedor,
            ':fecha'       => $fecha,
            ':total'       => $total
        ]);
    }

    public static function storeDetalleCompra($db, $idCompra, $idProducto, $cantidad, $precioUnitario, $descuento, $precioFinal, $precioTotal)
    {
        $stmt = $db->prepare("
            INSERT INTO detalle_compras (id_compra, id_producto, cantidad, precio_unitario, descuento, precio_final, total)
            VALUES (:idCompra, :idProducto, :cantidad, :precioUnitario, :descuento, :precioFinal, :precioTotal)
        ");
        $stmt->execute([
            ':idCompra'       => $idCompra,
            ':idProducto'     => $idProducto,
            ':cantidad'       => $cantidad,
            ':precioUnitario' => $precioUnitario,
            ':descuento'      => $descuento,
            ':precioFinal'    => $precioFinal,
            ':precioTotal'    => $precioTotal
        ]);

        // Actualizar stock sumando la cantidad comprada
        $stmtUpdate = $db->prepare("
            UPDATE productos
            SET stock_total = stock_total + :cantidad
            WHERE id = :idProducto
        ");
        $stmtUpdate->execute([
            ':cantidad'   => $cantidad,
            ':idProducto' => $idProducto
        ]);
    }

}
