<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Detalle del producto</title>
</head>
<body>
<?php include 'menuprod.php'; ?>
  <h1>Detalle del producto</h1>
  <?php 
  require "Funciones/conecta.php";
  $con = conecta();

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM productos WHERE id = $id";
    $res = $con->query($sql);
    $row = $res->fetch_array();
    
    if ($row) {
      $archivo = $row["archivo"];
      $archivo_n = $row["archivo_n"];
      $cadena = explode(".", $archivo_n);
      $pos = count($cadena)-1;
      $ext = $cadena[$pos];
    }
  }
  ?>
  <?php if ($row) { ?>
    <table>
      <tr>
        <th>Nombre del producto</th>
        <td><?php echo $row["nombre"]; ?></td>
      </tr>
      <tr>
        <th>Codigo</th>
        <td><?php echo $row["codigo"]; ?></td>
      </tr>
      <th>Costo</th>
        <td><?php echo $row["costo"]; ?></td>
      </tr>
      <tr>
      </tr>
      <th>Stock</th>
        <td><?php echo $row["stock"]; ?></td>
      </tr>
      <tr>
        <th>Descripcion</th>
        <td><?php echo $row["descripcion"]; ?></td>
      </tr>
      <tr>
        <th>Foto</th>
        <td>
          <div class="image-container">
            <?php 
              $direccion = "Imagenes/" . $archivo . "." . $ext;
              if ($archivo != '') {
                echo '<img src="' . "$direccion" . '">';
              } else {
                echo 'No hay foto disponible.';
              }
            ?>
          </div>
        </td>
      </tr>
    </table>
    <div><a href="productos_lista.php">Regresar al listado</a><div>
  <?php } else { ?>
    <p>No se encontró el producto.</p>
  <?php } ?>

</body>
<style>
    body {
      font-family: Arial, sans-serif;
    }
    h1 {
      margin-top: 20px;
      text-align: center;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin: 0 auto;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    tr:hover {
      background-color: #e6f7ff;
    }
    div{
      text-align: center;
      margin-top: 20px;
      
    }
    p {
      text-align: center;
      color: #666;
      margin-top: 20px;
    }
    .image-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 250px;
    }

    .image-container img {
      max-width: 100%;
      max-height: 100%;
    }
  </style>
</html>