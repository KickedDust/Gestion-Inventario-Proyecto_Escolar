<?php
//agregarProducto.php
session_start();
require "Funciones/conecta.php";
$con = conecta();

//Recibe variables
$idP  = $_REQUEST['idP'];
$cant = $_REQUEST['cant'];

$id_cliente = $_SESSION['id'];

//Obtener id_pedido
$sql = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$res = $con->query($sql);
$num = $res->num_rows;
if ($num == 0) {
    $fecha = date('Y-m-d H:i:s');
    $sql   = "INSERT into pedidos (fecha, id_cliente, status) VALUES ('$fecha', $id_cliente, 0)";
    $res   = $con->query($sql);
    $id_pedido = $con->insert_id;
} else {
    $row = $res->fetch_assoc();
    $id_pedido = $row['id'];
}

//Obtener costo
$sql = "SELECT costo FROM productos WHERE id = $idP";
$res = $con->query($sql);
$num = $res->num_rows;
if ($num) {
    $row = $res->fetch_assoc();
    $costo = $row['costo'];
}

if ($cant > 0) {
    //Verifica si ya se esta pidiendo ese producto
    $sql = "SELECT * FROM pedidos_productos WHERE id_producto = $idP AND id_pedido = $id_pedido";
    $res = $con->query($sql);
    $num = $res->num_rows;
    if ($num == 0) {
        $sql = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $idP, $cant, $costo);";
    } else {
        $row = $res->fetch_assoc();
        $sql = "UPDATE pedidos_productos SET cantidad = cantidad + $cant WHERE id_producto = $idP AND id_pedido = $id_pedido";
    }
   $resultado = $con->query($sql);
}
if ($resultado) {
    $exito = true;
    $mensaje = "Producto agregado con éxito";
} else {
    $exito = false;
    $mensaje = "Error al agregar el producto";
}

// Enviar respuesta en formato JSON
echo json_encode(array('exito' => $exito, 'mensaje' => $mensaje));

?>

