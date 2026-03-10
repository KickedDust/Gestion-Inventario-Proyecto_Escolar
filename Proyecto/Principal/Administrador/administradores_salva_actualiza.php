<?php
//administradores_actualiza.php

require "funciones/conecta.php";
$con = conecta();

//Recibe variables
$id 			= $_POST['id'];
$nombre 		= $_POST['nombre'];
$apellidos		= $_POST['apellidos'];
$correo 		= $_POST['correo'];
$rol 			= $_POST['rol'];
$archivo_n 		= '';
$archivo 		= '';

$sql = "UPDATE administradores SET 
			nombre = '$nombre',
			apellidos= '$apellidos',
			correo = '$correo',
			rol = '$rol'
			WHERE id = $id";

if (!empty($_POST['passw'])) {
	$pass = $_POST['passw'];
	$passEnc = md5($pass);
	$sql = "UPDATE administradores SET 
			nombre = '$nombre',
			apellidos= '$apellidos',
			correo = '$correo',
			pass = '$passEnc',
			rol = '$rol'
			WHERE id = $id";
}

if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
	$archivo_n  = $_FILES['archivo']['name'];
	$archivo  	= $_FILES['archivo']['tmp_name'];
	$cadena = explode(".", $archivo_n);
	$pos = count($cadena)-1;
	$ext = $cadena[$pos];
	$dir = "archivos/";
	$file_enc = md5_file($archivo);
	$fileName1 = "$file_enc.$ext";
	copy($archivo, $dir.$fileName1);

	if (empty($_POST['passw'])) {
		$sql = "UPDATE administradores SET 
				nombre = '$nombre',
				apellidos= '$apellidos',
				correo = '$correo',
				rol = '$rol',
				archivo_n = '$archivo_n',
				archivo = '$file_enc'
				WHERE id = $id";
	}
}

$res = $con->query($sql);

if ($res) {
  // Redirigir a la página de listado de administradores
  header("Location: administradores_lista.php");
  exit();
} else {
  // Mostrar un mensaje de error si la actualización falla
  echo "Error al actualizar el administrador en la base de datos.";
}
?>
