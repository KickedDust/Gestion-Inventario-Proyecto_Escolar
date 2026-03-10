<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .0 {
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            border-collapse: collapse;
        }
        .1 {
            text-align: center;
            padding: 10px;
            border: 0px solid #fff;
        }
        .center {
            text-align: center;
            border: 0px solid #f2f2f2;
            background-color: #f2f2f2;

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
    </style>
<body>
    <div class="center">
        <table class="0">
            <tr class="center">
                <td class="1, center"><a href="bienvenido.php"><button>Inicio</button></a></td>
                <td class="1, center"><a href="administradores_lista.php"><button>Administradores</button></a></td>
                <td class="1, center"><a href="productos/productos_lista.php"><button>Productos</button></a></td>
                <td class="1, center"><a href="banners/banners_lista.php"><button>Banners</button></a></td>
                <td class="1, center"><a href="pedidos/pedidos_lista.php"><button>Pedidos</button></a></td>
                <td class="1, center"><button class="welcome">Bienvenido <?php echo $_SESSION["nombre"] ?></button></td>
                <td class="1, center"><button class="logout" onclick="confirmarCerrarSesion()">Cerrar sesión</button></td>
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
</html>
