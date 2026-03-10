<?php
session_start();
// Actualizar el estado del pedido a 1
require "conecta.php";
$con = conecta();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPedido = $_POST["idPedido"];
    
    $sqlUpdate = "UPDATE pedidos SET status = 1 WHERE id = '$idPedido'";
    $con->query($sqlUpdate);
}

header("Location: ../confirm.php");
exit();
?>
