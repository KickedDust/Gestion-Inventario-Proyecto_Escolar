<?php
require "Funciones/conecta.php";

$con = conecta();
$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$encPass = md5($pass);
$ban = 0;

$sql = "SELECT correo, id, nombre FROM administradores WHERE status = 1 AND eliminado = 0 
        AND correo = '$correo' 
        AND pass = '$encPass'";

$res = $con->query($sql);

if (mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    session_start();
    $_SESSION["id"] = $row["id"];
    $_SESSION["nombre"] = $row["nombre"];
    echo 0;
} else {
    $ban = 1;
    echo $ban;
}
?>
