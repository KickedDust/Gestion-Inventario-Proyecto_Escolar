<?php
//cerrarPedido.php
session_start();
require "Funciones/conecta.php";
$con = conecta();

$id_cliente = $_SESSION['id'];

//Obtener id_pedido
$sql = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$res = $con->query($sql);
$num = $res->num_rows;
if ($num) {
    $row = $res->fetch_assoc();
    $id_pedido = $row['id'];
    $sql = "UPDATE pedidos SET status = 1 WHERE id = $id_pedido";
    $con->query($sql);
    echo 1;
} else {
    echo 0;
}
?>
