<?php
//productos_actualiza.php

require "Funciones/conecta.php";
$con = conecta();

//Recibe variables
$id 			= $_POST['id'];
$nombre 		= $_POST['nombre'];
$codigo			= $_POST['codigo'];
$costo			= $_POST['costo'];
$stock 			= $_POST['stock'];
$descripcion	= $_POST['descripcion'];
$archivo_n 		= '';
$archivo 		= '';

$sql = "UPDATE productos SET 
			nombre = '$nombre',
			codigo = '$codigo',
			costo = '$costo',
			stock = '$stock',
			descripcion = '$descripcion'
			WHERE id = $id";

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

	$sql = "UPDATE productos SET 
			nombre = '$nombre',
			codigo = '$codigo',
			costo = '$costo',
			stock = '$stock',
			descripcion = '$descripcion',
			archivo_n = '$archivo_n',
			archivo = '$file_enc'
			WHERE id = $id";
}

$res = $con->query($sql);

if ($res) {
  // Redirigir a la página de listado de productos
  header("Location: productos_lista.php");
  exit();
} else {
  // Mostrar un mensaje de error si la actualización falla
  echo "Error al actualizar el producto en la base de datos.";
}
?>
