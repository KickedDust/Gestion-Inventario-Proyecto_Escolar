<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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
	<main>
		<div class="banner">
			<?php
			require "Funciones/conecta.php";
			$con = conecta();

			// Consulta para obtener una imagen de forma aleatoria
			$sql = "SELECT archivo, archivo_n FROM banners WHERE eliminado = 0  ORDER BY RAND() LIMIT 1";
			$res = $con->query($sql);
			$row = $res->fetch_assoc();

			$archivo = $row["archivo"];
			$archivo_n = $row["archivo_n"];

			// Si se encuentra una imagen, mostrarla
			if ($archivo != '') {
				$cadena = explode(".", $archivo_n);
				$pos = count($cadena) - 1;
				$ext = $cadena[$pos];
				$direccion = "Administrador/banners/Imagenes/" . $archivo . "." . $ext;
				echo '<img src="' . $direccion . '">';
			} else {
				echo 'No hay foto disponible.';
			}
			 ?>
		</div>
		<div class="productos">
    <?php
    $query = "SELECT * FROM productos WHERE eliminado = 0 AND stock >=1 ORDER BY RAND() LIMIT 6";
    $resultado = mysqli_query($con, $query);

    while ($producto = mysqli_fetch_array($resultado)) {
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
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION["id"])) {
            echo '<form method="POST" action="agregarProducto.php">';
            echo '<input type="hidden" name="idP" value="' . $producto['id'] . '">';
            echo '<label for="cantidad">Cantidad:</label>';
            echo '<input type="number" name="cant" id="cantidad" min="1" max="100" value="1">';
            echo '<input type="submit" value="Agregar al carrito">';
            echo '</form>';
			echo '<div class="mensaje" id="mensaje-' . $producto['id'] . '" style="display: none; margin: 0;"></div>';
        }
        echo "</div>";
    }
    mysqli_close($con);
    ?>
</div>

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
		text-align: center;
		color: #333;
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
	.banner {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 300px;
		margin-top: 30px;
	}
	.banner img {
		max-width: 100%;
		max-height: 100%;
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
		justify-content: center;
		align-items: center;
		background: white;
 
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
	form {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: center;
		margin-top: 10px;
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
