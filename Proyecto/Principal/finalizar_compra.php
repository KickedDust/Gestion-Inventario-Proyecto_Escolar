<?php
session_start();
require "Funciones/conecta.php";
$con = conecta();

// Obtener el ID del pedido a finalizar
$pedido_id = $_POST['pedido_id'];

// Actualizar el estado del pedido a 1
$sqlUpdate = "UPDATE pedidos SET status = 1 WHERE id = '$pedido_id'";
$con->query($sqlUpdate);

// Mostrar el mensaje de compra exitosa
echo "Esta fue su compra y se realizó de manera exitosa.";

// Obtener todos los productos del pedido
$sqlPedProd = "SELECT * FROM pedidos_productos WHERE id_pedido = '$pedido_id'";
$resPedProd = $con->query($sqlPedProd);

// Mostrar la tabla con los productos del pedido
echo "<h2>Detalles del pedido #$pedido_id</h2>";
echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Subtotal</th>
      </tr>";

$total = 0; // Inicializar la variable total a cero

while ($rowPp = $resPedProd->fetch_array()) {
    $id_producto = $rowPp["id_producto"];
    $cantidad = $rowPp["cantidad"];
    $precio = $rowPp["precio"];

    $sqlProd = "SELECT * FROM productos WHERE id = '$id_producto'";
    $resProd = $con->query($sqlProd);
    $rowProd = $resProd->fetch_array();

    $nombreProducto = $rowProd["nombre"];
    $precioTotalProducto = $precio * $cantidad;
    $total += $precioTotalProducto; // Sumar el total del producto al total general

    echo "<tr>
            <td>$id_producto</td>
            <td>$nombreProducto</td>
            <td>$cantidad</td>
            <td>$precio</td>
            <td>$precioTotalProducto</td>
          </tr>";
}

echo "<tr>
        <td colspan='4' style='text-align:right; color:red;'>Total:</td>
        <td>$total</td>
      </tr>";
echo "</table>";

// Redireccionar a la página de carrito
header("Location: carrito.php");
exit();
?>
