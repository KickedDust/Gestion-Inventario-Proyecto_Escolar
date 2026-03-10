<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            padding: 8px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
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
        .logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 70vh;
      }

      .logo img {
        height: 200px;
      }

      .logo::after {
        content: "¡Vamos a comprar!";
        font-size: 24px;
        margin-top: 16px;
      }
    </style>
<body>
    <h1>Bienvenido al Sistema de Administración.</h1>

    <div>
        <table>
            <tr>
                <td><a href="bienvenido.php"><button>Inicio</button></a></td>
                <td><a href="administradores_lista.php"><button>Administradores</button></a></td>
                <td><a href="productos/productos_lista.php"><button>Productos</button></a></td>
                <td><a href="banners/banners_lista.php"><button>Banners</button></a></td>
                <td><a href="pedidos/pedidos_lista.php"><button>Pedidos</button></a></td>
                <td><button class="welcome">Bienvenido <?php echo $_SESSION["nombre"] ?></button></td>
                <td><button class="logout" onclick="confirmarCerrarSesion()">Cerrar sesión</button></td>
            </tr>
        </table>
    </div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmarCerrarSesion() {
            if (confirm("¿Está seguro de que desea cerrar sesión?")) {
                cerrarSesion();
            }
        }
        function cerrarSesion() {
            $.ajax({
                url: 'cerrar_sesion.php',
                type: 'POST',
                success: function() {
                    location.href = 'index.php';
                },
                error: function() {
                    alert('Error al cerrar sesión');
                }
            });
        }
    </script>
</body>
<!--<a href="../principal.php" class="logo"><img src="../Apple_logo_black.svg"></a>-->
<div class="logo">
<a href="../principal.php">
    <img src="../Apple_logo_black.svg" alt="Logo">
</a>
</div>
</html>
