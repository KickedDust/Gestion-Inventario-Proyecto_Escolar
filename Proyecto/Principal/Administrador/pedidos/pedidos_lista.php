<?php
session_start();
if(!isset($_SESSION["id"])){
	header("Location: index.php");
}

require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM pedidos WHERE status = 1";
$res = $con->query($sql);
?>
<?php include 'menuped.php'; ?>
<table class="table">
  <th colspan="8">
    <h1>Listado de pedidos</h1>
  </th>
  <tr class="tr1"><td colspan="8"></td></tr>
  <tr class="tr1">
    <th>ID</th>
    <th>Fecha</th>
    <th>Ver detalle</th>
  </tr>
  <?php while($row = $res->fetch_array()) { ?>
    <tr class="tr1" id="row_<?php echo $row['id']; ?>">
      <td><?php echo $row["id"]; ?></td>
      <td><?php echo $row["fecha"]?></td>
      <td><a href="detalle_pedidos.php?id=<?php echo $row['id']; ?>">Ver detalle</a></td> 
    </tr>
  <?php } ?>
</table>
<style>
  
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
  
  }
  tr1{
    text-align: left;
  }

  th, td {
    padding: 8px;
    border: 1px solid #ddd;
  }

  th {
    text-align: center;
    background-color: #f2f2f2;
  }

  tr:hover {
    background-color: #f5f5f5;
  }

  a {
    color: #0066cc;
  }

  a:hover {
    text-decoration: underline;
  }
</style>