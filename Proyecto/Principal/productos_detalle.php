<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalle del producto</title>
</head>

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

    <h1>Detalle del producto</h1>

    <?php 
        require "Funciones/conecta.php";
        $con = conecta();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT * FROM productos WHERE id = $id";
            $res = $con->query($sql);
            $row = $res->fetch_array();

            if ($row) {
                $archivo = $row["archivo"];
                $archivo_n = $row["archivo_n"];
                $cadena = explode(".", $archivo_n);
                $pos = count($cadena) - 1;
                $ext = $cadena[$pos];
            }
        }

        if ($row) { 
    ?>
        <div class="producto-info">
            <img src="Administrador/productos/Imagenes/<?php echo $archivo . "." . $ext; ?>" alt="No existe imagen del producto">
            <div class="datos-producto">
                <h2><?php echo $row["nombre"]; ?></h2>
                <p><strong>Código:</strong> <?php echo $row["codigo"]; ?></p>
                <p><strong>Costo:</strong> <?php echo $row["costo"]; ?></p>
                <p><strong>Stock:</strong> <?php echo $row["stock"]; ?></p>
                <p><strong>Descripción:</strong> <?php echo $row["descripcion"]; ?></p>

                <?php 
                    if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION["id"])) {
                        echo '<form method="POST" action="agregarProducto.php">';
                        echo '<input type="hidden" name="idP" value="' . $row['id'] . '">';
                        echo '<label for="cantidad">Cantidad:</label>';
                        echo '<input type="number" name="cant" id="cantidad" min="1" max="100" value="1">';
                        echo '<input type="submit" value="Agregar al carrito">';
                        echo '</form>';
						echo '<div class="mensaje" id="mensaje-' . $row['id'] . '" style="display: none; margin: 0;"></div>';
                    } 
                ?>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Regresar</a>
            </div>
        </div>

    <?php 
        } else { 
    ?>
        <p>No se encontró el producto.</p>
    <?php 
        } 
    ?>
    <h2 class="sub">Otros productos</h2>
<div class="productos">
    <?php
    $query = "SELECT * FROM productos WHERE eliminado = 0 AND stock >=1 ORDER BY RAND() LIMIT 3";
    $resultado = $con->query($query);
    if ($resultado->num_rows > 0) {
        while ($producto = $resultado->fetch_assoc()) {
            echo "<div>";
            $archivo = $producto["archivo"];
            $archivo_n = $producto["archivo_n"];
            if ($archivo != '') {
                $cadena = explode(".", $archivo_n);
                $pos = count($cadena) - 1;
                $ext = $cadena[$pos];
                $direccion1 = "Administrador/productos/Imagenes/" . $archivo . "." . $ext;
                echo '<img src="' . $direccion1 . '">';
            } else {
                echo 'No hay foto disponible.';
            }
            echo "<h2>" . $producto['nombre'] . "</h2>";

            echo "<p>Precio: $" . $producto['costo'] . "</p>";
			echo '<a href="productos_detalle.php?id=' . $producto['id'] . '">Ver detalle</a>';
            if (isset($_SESSION["id"])) {
				echo '<form method="POST" action="agregarProducto.php">';
				echo '<input type="hidden" name="idP" value="' . $producto['id'] . '">';
				echo '<label for="cantidad">Cantidad:</label>';
				echo '<input type="number" name="cant" id="cantidad" min="1" max="100" value="1">';
				echo '<input type="submit" value="Agregar al carrito">';
				echo '</form>';
				echo '<div class="mensaje" id="mensaje-' . $producto['id'] . '" style="display: none; margin: 0;"></div>';
            } 
            echo '</div>';
        }
    } else {
        echo 'No se encontraron productos.';
    }
    $con->close(); // Cerramos la conexión con la base de datos
    ?>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('form').submit(function(event) {
        event.preventDefault();
        var form = $(this);
        var productoId = form.find('input[name="idP"]').val();
        var mensajeDiv = $('#mensaje-' + productoId);
        $.ajax({
            url: 'agregarProducto.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                var mensaje = data.mensaje;
                if (data.exito) {
                    mensajeDiv.removeClass('error').addClass('exito').text(mensaje).fadeIn();
                } else {
                    mensajeDiv.removeClass('exito').addClass('error').text(mensaje).fadeIn();
                }
                setTimeout(function() {
                    mensajeDiv.fadeOut();
                }, 5000);
            },
            error: function() {
                mensajeDiv.removeClass('exito').addClass('error').text('Ha ocurrido un error al enviar la petición.').fadeIn();
                setTimeout(function() {
                    mensajeDiv.fadeOut();
                }, 5000);
            }
        });
    });
});
</script>
<footer>
  	<p>&copy; 2023 - KickedDust   |   Todos los derechos reservados  |  Politica de Privadidad |  Terminos y condiciones</p>
</footer>	
<style>
	body {
		font-family: Arial, sans-serif;
	}
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
		background-color: #f2f2f2;
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
    .producto-info {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-around;
			align-items: center;
			margin-top: 50px;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
		}
		.producto-info img {
			width: 50%;
			max-width: 400px;
			display: block;
			margin: 0 auto;
		}
		.producto-info .datos-producto {
			width: 50%;
			margin-left: 30px;
			text-align: left;
		}
		.producto-info h2 {
			margin: 0;
			margin-bottom: 10px;
			font-size: 24px;
            color: red;
		}
		.producto-info p {
			margin: 0;
			margin-bottom: 20px;
			font-size: 18px;
		}
		.producto-info a {
			display: block;
			text-align: center;
			margin-top: 20px;
			padding: 10px 20px;
			background-color: #0099cc;
			color: #fff;
			text-decoration: none;
			border-radius: 5px;
			transition: all 0.3s ease;
		}
		.producto-info a:hover {
			background-color: #006699;
		}
        .productos {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
		align-items: center;
		margin-top: 20px;
		background-color: #f2f2f2;
	}
	.productos div {
		width: 30%;
		margin-bottom: 20px;
		text-align: center;
		border: 1px solid #ddd;
		border-radius: 5px;
		padding: 10px;
		box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
		background-color: #FFFFFF
	}
	.productos div img {
		max-width: 600px;
		max-height: 200px;
		height: auto;
		margin-bottom: 10px;
	}
	.productos div h2 {
		font-size: 20px;
		margin-bottom: 10px;
	}

	.productos div p {
		font-size: 16px;
		margin-bottom: 10px;
	}
	.mensaje {
    text-align: center;
    color: red;
	font-size: 16px;
	margin-bottom: 10px;
	margin: 0px;
    display: table-cell;
  }

	.productos div button {
		background-color: #007bff;
		color: #fff;
		border: none;
		padding: 10px 20px;
		border-radius: 5px;
		cursor: pointer;
		transition: background-color 0.3s ease;
	}

	.productos div button:hover {
		background-color: #0062cc;
	}
    input[type="number"] {
		width: 40px;
		height: 25px;
		margin-right: 10px;
		font-size: 16px;
	}

	input[type="submit"] {
		background-color: #4CAF50;
		color: white;
		padding: 8px 20px;
		border: none;
		cursor: pointer;
		border-radius: 5px;
		font-size: 16px;
	}
	footer {
		background-color: #ffffff;
		padding: 10px;
		font-size: 14px;
		text-align: center;
	}
  </style>
</html>