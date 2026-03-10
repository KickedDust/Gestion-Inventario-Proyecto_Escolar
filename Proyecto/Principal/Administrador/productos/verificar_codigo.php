<?php
// Conexión a la base de datos
require "Funciones/conecta.php";
$con = conecta();

// Verificar si la conexión fue exitosa
if (!$con) {
  die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Obtener el código enviado por POST
$codigo = $_POST["codigo"];

// Realizar una consulta para verificar si el código ya existe
$sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
$resultado = mysqli_query($con, $sql);

if (!$resultado) {
  die("Error al ejecutar la consulta: " . mysqli_error($con));
}

// Si el código ya existe, retornar "existe", sino retornar "no_existe"
if (mysqli_num_rows($resultado) > 0) {
  echo "existe";
} else {
  echo "no_existe";
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>
