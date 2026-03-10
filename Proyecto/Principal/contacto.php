<html>
<header>
    <title>Contacto</title>
    <a href="Administrador/index.php" class="logo"><img src="Apple_logo_black.svg"></a>
    <nav>
	<a href="principal.php"><button>Home</button></a>
    <a href="productos.php"><button>Productos</button></a>
	<a href="contacto.php"><button>Contacto</button></a>
	<a href="carrito.php"><button>Carrito</button></a>
    </nav>
</header>
<body>
    <h1>CONTACTANOS</h1>
    <p id="mensaje-agradecimiento" style="display: none;">Gracias por sus comentarios.<br>Lo atenderemos lo antes posible.<br>:)</p>
    <form id="formulario" method="post" action="" onsubmit="return validarFormulario()">
        <label>Nombre:</label>
        <input type="text" name="nombre"><br>
        <label>Tu correo:</label>
        <input type="email" name="email" ><br>
        <label>Comentarios:</label>
        <textarea name="comentarios" rows="5" cols="40"></textarea><br>
        <input type="submit" name="submit" value="Enviar">
        <div id="errores" style="color: red;"></div>
    </form>

    <script>
        function validarFormulario() {
            var nombre = document.forms["formulario"]["nombre"].value;
            var email = document.forms["formulario"]["email"].value;
            var comentarios = document.forms["formulario"]["comentarios"].value;

            var errores = [];
            if (nombre == "") {
                errores.push("Por favor, ingrese su nombre.");
            }
            if (email == "") {
                errores.push("Por favor, ingrese su correo.");
            }
            if (comentarios == "") {
                errores.push("Por favor, ingrese sus comentarios.");
            }

            var erroresDiv = document.getElementById("errores");
            erroresDiv.innerHTML = "";

            if (errores.length > 0) {
                for (var i = 0; i < errores.length; i++) {
                    erroresDiv.innerHTML += errores[i] + "<br>";
                }
                return false;
            } else {
                document.getElementById("formulario").style.display = "none";
                document.getElementById("mensaje-agradecimiento").style.display = "block";
                return false;
            }
        }
    </script>
</body>

<footer>
  	<p>&copy; 2023 - KickedDust   |   Todos los derechos reservados  |  Politica de Privadidad |  Terminos y condiciones</p>
</footer>
<style>
	footer {
		background-color: #ffffff;
		padding: 10px;
		font-size: 14px;
		text-align: center;
	}
    #errores {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: center;
  background-color: #f2f2f2;
  margin-top: 20px;
  }
  #mensaje-agradecimiento {
    display: none;
    font-size: 65px;
    font-weight: bold;
    color: forestgreen;
    text-align: center;
    margin-top: 160px;
    }   

    body {
		font-family: Arial, sans-serif;
	}
	h1 {
		text-align: center;
		color: #333;
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
        form {
            width: 50%;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</html>
