<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location:../Administrador/index.php");
    exit();
}

require "conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProducto = $_POST["idProducto"];

    // Obtener el ID autoincremental para el idProducto dado
    $sqlGetID = "SELECT id FROM pedidos_productos WHERE id_producto = '$idProducto' LIMIT 1";
    $resultGetID = $con->query($sqlGetID);

    if ($resultGetID->num_rows > 0) {
        $row = $resultGetID->fetch_assoc();
        $id = $row["id"];

        // Realizar las operaciones necesarias en la base de datos para eliminar la fila con el ID obtenido
        $sqlDelete = "DELETE FROM pedidos_productos WHERE id = '$id'";
        $resultDelete = $con->query($sqlDelete);

        if ($resultDelete) {
            // Fila eliminada exitosamente
            echo "¡Fila eliminada exitosamente!";
        } else {
            // Error al eliminar la fila
            echo "Error al eliminar la fila.";
        }
    } else {
        // No se encontró ningún ID coincidente
        echo "No se encontró ningún ID coincidente.";
    }
} else {
    echo "¡Solicitud inválida!";
}