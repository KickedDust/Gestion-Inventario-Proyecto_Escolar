<?php
// valida_correo.php
require "Funciones/conecta.php";
$con = conecta();

$correo = $_POST['correo'];

$sql = "SELECT * FROM administradores WHERE correo = '$correo'";
$res = $con->query($sql);

if ($res->num_rows > 0) {
  echo 'existe';
} else {
  echo 'no_existe';
}
?>
