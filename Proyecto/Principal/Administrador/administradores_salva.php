<?php
require "Funciones/conecta.php";
$con = conecta();

//Recibe variables
$nombre 		= $_REQUEST['nombre'];
$apellidos		= $_REQUEST['apellidos'];
$correo 		= $_REQUEST['correo'];
$pass 			= $_REQUEST['pass'];
$rol 			= $_REQUEST['rol'];
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
$passEnc = md5($pass);
$sql = "INSERT INTO administradores
		(nombre, apellidos, correo, pass, rol, archivo_n, archivo)
		VALUES ('$nombre', '$apellidos', '$correo', '$passEnc', $rol, '$archivo_n', '$file_enc');";

$res = $con->query($sql);

header("Location: administradores_lista.php");
?>
