<?php
require "Funciones/conecta.php";
$con = conecta();

//Recibe variables
$nombre 		= $_REQUEST['nombre'];
$archivo_n  	= '';
$archivo  		= '';

$dir = "Imagenes/";
//$id = $_REQUEST['id'];

if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
	$archivo_n  = $_FILES['archivo']['name'];
	$archivo  	= $_FILES['archivo']['tmp_name'];
	$cadena = explode(".", $archivo_n);
	$pos = count($cadena)-1;
	$ext = $cadena[$pos];
	$dir = "Imagenes/";
	$file_enc = md5_file($archivo);
	$fileName1 = "$file_enc.$ext";
    copy($archivo, $dir.$fileName1);
}

//$sql = "DELETE FROM administradores WHERE id = $id";
$sql = "INSERT INTO banners
		(nombre,archivo_n, archivo)
		VALUES ('$nombre','$archivo_n', '$file_enc');";

$res = $con->query($sql);
header("Location: banners_lista.php");
exit();
?>
