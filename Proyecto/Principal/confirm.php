<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Confirmado</title>
    <script>
		// Función para redireccionar a principal.php después de 5 segundos
		function redireccionar() {
			setTimeout(function() {
				window.location.href = 'principal.php';
			}, 5000); // 5000 milisegundos = 5 segundos
		}
	</script>
</head>
<body onload="redireccionar()">
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
<h1>Compra realizada con éxito</h1>
<h2>Redireccionando a Home en 5 segundos</h2>
</main>
</body>
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
       main{

    margin-top: 220px;
       }
       
       h1{
         color: red;
       }
       h2{
   color: blue;
   text-align: center;
       }

 </style>
</html>