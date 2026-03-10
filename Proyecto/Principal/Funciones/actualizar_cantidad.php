<?php
session_start();
require "conecta.php";
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProducto = $_POST['idProducto'];
    $nuevaCantidad = $_POST['nuevaCantidad'];

    // Actualizar la cantidad en la base de datos
    $sqlUpdateCantidad = "UPDATE pedidos_productos SET cantidad = '$nuevaCantidad' WHERE id_producto = '$idProducto'";
    $con->query($sqlUpdateCantidad);

    // Puedes realizar otras acciones adicionales aquí si es necesario

    echo "Cantidad actualizada exitosamente";
} else {
    echo "Error al procesar la solicitud";
}
if ($con->query($sqlUpdateCantidad) === TRUE) {
    echo "Cantidad actualizada exitosamente";
} else {
    echo "Error al actualizar la cantidad: " . $con->error;
}
?>
