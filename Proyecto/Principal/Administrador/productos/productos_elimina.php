<?php
// producto_elimina.php
require "Funciones/conecta.php";
$con = conecta();

$ban = 0;

//Recibe variables
$idA = $_REQUEST['id'];
$sql = "UPDATE productos SET eliminado = 1 WHERE id = $idA";

if ($idA) {
	$ban = 1;
	$con->query($sql);
}

echo $ban;

//header("Location: productos_lista.php");
?>