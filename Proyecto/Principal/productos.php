<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Productos</title>
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
    <h1>Productos</h1>
    <div class="productos">
    <?php
    require "Funciones/conecta.php";
    $con = conecta();
    $por_pagina = 6;
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $inicio = ($pagina > 1) ? ($pagina * $por_pagina - $por_pagina) : 0;

    $query = "SELECT * FROM productos WHERE eliminado = 0 AND stock >=1 LIMIT $inicio,$por_pagina";
    $resultado = mysqli_query($con, $query);

    while ($producto = mysqli_fetch_array($resultado)) {
        echo '<div class="producto">';
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
    ?>
</div>
<div class="pagination">
    <?php
    $query_total = "SELECT COUNT(*) as total FROM productos WHERE eliminado = 0";
    $resultado_total = mysqli_query($con, $query_total);
    $fila = mysqli_fetch_assoc($resultado_total);
    $total_paginas = ceil($fila['total'] / $por_pagina);

    if ($pagina > 1) {
        echo '<a href="?pagina=' . ($pagina - 1) . '">Anterior</a>';
    }
    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($pagina == $i) {
            echo '<span class="current">' . $pagina . '</span>';
        } else {
            echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
        }
    }
    if ($pagina < $total_paginas) {
        echo '<a href="?pagina=' . ($pagina + 1) . '">Siguiente</a>';
    }
    mysqli_close($con);
    ?>

</div>

</main>
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
    color: red;
    text-align: center;
    margin-top: 30px;
    margin-bottom: 30px;
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
		background-color: #3e8e41;
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
    .pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination a {
  color: #000;
  display: inline-block;
  padding: 10px;
  margin: 0 5px;
  border-radius: 5px;
  text-decoration: none;
  background-color: #eee;
}

.pagination a.active {
  background-color: #007bff;
  color: #fff;
}

.pagination a:hover {
  background-color: #007bff;
  color: #fff;
}

	</style>
</html>
