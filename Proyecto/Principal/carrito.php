
<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location:Administrador/index.php");
}
?>
<?php
require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT id FROM pedidos WHERE status = 0 LIMIT 1";
$res = $con->query($sql);

if ($res->num_rows == 0) {
    echo "<h1>No se a realizado ningun pedido aun.</h1>";
    echo '<br><style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 27px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 120px;
            margin-left: 120px;
        }
        a{
            color: white;
        }

    </style><br>';
    echo '<script>setTimeout(function(){ window.location.href = "principal.php"; }, 3000);</script>';
    exit();
}


$row = $res->fetch_array();
$id = $row["id"];

$sqlPedProd = "SELECT * FROM pedidos_productos WHERE id_pedido = '$id'  AND cantidad >= 1";
$resPedProd = $con->query($sqlPedProd);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para actualizar la cantidad de un producto en la base de datos
            function actualizarCantidad(idProducto, nuevaCantidad) {
                $.ajax({
                    url: 'Funciones//actualizar_cantidad.php',
                    method: 'POST',
                    data: {
                        idProducto: idProducto,
                        nuevaCantidad: nuevaCantidad
                    },
                    success: function(response) {
                        console.log(response); // Para verificar la respuesta en la consola del navegador
                        location.reload();
                    }
                });
            }
            // Escuchar el evento de clic en cualquier botón de cantidad
            $(".cantidad-menos, .cantidad-mas").on('click', function() {
                var idProducto = $(this).data('id');
                var cantidadActual = parseInt($("#cantidad-" + idProducto).text());
                var nuevaCantidad = cantidadActual;
                if ($(this).hasClass("cantidad-menos")) {
                    nuevaCantidad = cantidadActual - 1;
                    if (nuevaCantidad < 0) {
                        nuevaCantidad = 0;
                    }
                } else {
                    nuevaCantidad = cantidadActual + 1;
                }
                $("#cantidad-" + idProducto).text(nuevaCantidad);
                actualizarCantidad(idProducto, nuevaCantidad);
            });
        });
    </script>
<body>
    <header>
        <a href="Administrador/index.php" class="logo"><img src="Apple_logo_black.svg"></a>
        <nav>
            <a href="principal.php"><button>Home</button></a>
            <a href="productos.php"><button>Productos</button></a>
            <a href="contacto.php"><button>Contacto</button></a>
            <a href="carrito.php"><button>Carrito</button></a>
        </nav>
    </header>
    <main>
        <h1>Carrito</h1>
        <div class="container">
            <h2>Detalles del pedido</h2>
            <?php
            $sqlPedido = "SELECT id_cliente FROM pedidos WHERE id = '$id'";
            $resPedido = $con->query($sqlPedido);
            $rowPedido = $resPedido->fetch_array();
            $idCliente = $rowPedido["id_cliente"];
            ?>
            <table>
    <tr>
        <td>Id Cliente:</td>
        <td><?php echo $idCliente; ?></td>
    </tr>
    <tr>
        <th>Productos:</th>
    </tr>

    <tr>
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
        $sqlProd = "SELECT * FROM productos WHERE id = '$id_producto' AND stock >=1";
        $resProd = $con->query($sqlProd);
        $rowProd = $resProd->fetch_array();
        $nombreProducto = $rowProd["nombre"];
        $precioTotalProducto = $precio * $cantidad;
        $total += $precioTotalProducto; // sumar el total del producto al total general
        ?>
        <tr id="pedido-<?php echo $id; ?>">
            <td>Producto #<?php echo $id_producto; ?></td>
            <td>
                <div><?php echo $nombreProducto; ?></div>
            </td>
            <td>
                <div>
                    <button class="cantidad-menos" data-id="<?php echo $id_producto; ?>">-</button>
                    <span id="cantidad-<?php echo $id_producto; ?>"><?php echo $cantidad; ?></span>
                    <button class="cantidad-mas" data-id="<?php echo $id_producto; ?>">+</button>
                </div>
            </td>
            <td>
                <div>$ <?php echo $precio; ?></div>
            </td>
            <td>
                <div id="subtotal-<?php echo $id_producto; ?>" class="subtotal">$ <?php echo $precioTotalProducto; ?></div>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="4" style="text-align:right; color:red;">Total:</td>
        <td>
            <div id="total">$ <?php echo $total; ?></div>
        </td>
    </tr>
</table>
<br>
</div>
</main>
<form action="carrito2.php" method="POST">
    <input type="hidden" name="idPedido" value="<?php echo $id; ?>">
    <button class="button1" type="submit">Comprar</button>
</form>
 <footer>
 	<p>&copy; 2023 - KickedDust   |   Todos los derechos reservados  |  Politica de Privadidad |  Terminos y condiciones</p>
</footer>	
<style>
    h1 {
    font-size: 3em;
    color: #333;
    text-align: center;
    margin-top: 30px;
    margin-bottom: 30px;
  }
  .sub{
    font-size: 2em;
    margin-top: 20px;
    margin-bottom: 20px;
    color: red;
    text-align: center;
  }
	table {
		width: 100%;
		margin-top: 20px;
		border-collapse: collapse;
	}
	td {
		text-align: center;
		padding: 10px;
	}
	button {
		background-color: #4CAF50;
		color: white;
		padding: 15px 27px;
		border: none;
		cursor: pointer;
		border-radius: 5px;
		font-size: 16px;
		margin-right: 120px;
		margin-left: 120px;
	}
    .button1 {
		background-color: #4CAF50;
		color: white;
		padding: 15px 27px;
		border: none;
		cursor: pointer;
		border-radius: 5px;
		font-size: 16px;
		margin-left: 172px;
	}
	button:hover {
		background-color: red;
	}
	.welcome {
		font-size: 18px;
		font-weight: bold;
	}
	.logout {
		background-color: #f44336;
	}
	.logout:hover {
		background-color: #d32f2f;
	}
	header {
		background-color: #f2f2f2;
		color: #fff;
		display: flex;
		align-items: center;
		padding: 10px;
	}
	.logo img {
		height: 75px;
	}
	nav {
		display: flex;
		align-items: center;
		justify-content: center;
		flex-wrap: wrap;
		margin: 0 auto; 
		max-width: 100%;
	}
	nav ul {
		list-style: none;
		display: flex;
	}
	nav li {
		margin-left: 20px;
	}
	nav a {
		color: #fff;
		text-decoration: none;
	}
	nav a:hover {
		text-decoration: underline;
	}
    footer {
		background-color: #ffffff;
		padding: 10px;
		font-size: 14px;
		text-align: center;
	}
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
        }
        #enlace-contenedor {
  text-align: center;
}
  </style>
</html>