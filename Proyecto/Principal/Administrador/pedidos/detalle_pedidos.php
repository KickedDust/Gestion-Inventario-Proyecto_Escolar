<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

$id = $_REQUEST['id'];
require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM pedidos WHERE id = '$id'";
$res = $con->query($sql);

if ($res->num_rows == 0) {
    echo "No se encontró el pedido con ID: $id";
    exit();
}

$row = $res->fetch_array();
$idCliente = $row["id_cliente"];

$sqlPedProd = "SELECT * FROM pedidos_productos WHERE id_pedido = '$id' AND cantidad >= 1";
$resPedProd = $con->query($sqlPedProd);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles Pedido <?php echo $id; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #006bff;
            color: white;
            font-weight: normal;
            text-align: left;
            padding: 10px;
        }

        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .back-button {
            display: inline-block;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #3e8e41;
        }
        h1{
          color: red;
          text-align: center;
        }
        #enlace-contenedor {
  text-align: center;
}
    </style>
    <?php include 'menuped.php'; ?>
</head>

<body>
    <div class="container">
        <h1>Detalles Pedido #<?php echo $id; ?></h1>
        <table>
            <tr>
                <td>Id Cliente:</td>
                <td><?php echo $idCliente; ?></td>
            </tr>
            <tr>
                <th>Productos:</th>
            </tr>
    <th>ID:</th>
    <th>Nombre:</th>
    <th>Cantidad:</th>
    <th>Precio:</th>
    <th>Subtotal:</th>
</tr>
<?php
$total = 0; // inicializar la variable total a cero
while ($rowPp = $resPedProd->fetch_array()) {
    $id_producto = $rowPp["id_producto"];
    $cantidad = $rowPp["cantidad"];
    $precio = $rowPp["precio"];
    $sqlProd = "SELECT * FROM productos WHERE id = '$id_producto'";
    $resProd = $con->query($sqlProd);
    $rowProd = $resProd->fetch_array();
    $nombreProducto = $rowProd["nombre"];
    $precioTotalProducto = $precio * $cantidad;
    $total += $precioTotalProducto; // sumar el total del producto al total general
?>

<tr>
    <td>Producto #<?php echo $id_producto; ?></td> 
    <td><div><?php echo $nombreProducto; ?></div></td>
    <td><div><?php echo $cantidad; ?></div></td> 
    <td><div>$ <?php echo $precio; ?></div></td> 
    <td><div>$ <?php echo $precioTotalProducto; ?></div></td> 
</tr>

<?php } ?>

<tr>
<td colspan="4" style="text-align:right; color:red;">Total:</td>
    <td>$ <?php echo $total; ?></td>
</tr>


</div>
    </table>
</div>
<div id="enlace-contenedor">
  <br><br>
  <a href="pedidos_lista.php">Regresar al listado</a>
</div>