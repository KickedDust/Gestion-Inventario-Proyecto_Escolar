<?php
//productos_lista.php
require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM banners WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);
?>
 <?php include 'menubann.php'; ?>
<table class="table">
  <th colspan="9">
    <h1>Listado de banners</h1>
  </th>
  <tr class="tr1"><td colspan="9"><a href = "form_banners.php" class="btn btn-primary mb-3">Crear nuevo banner</a></td></tr>
  <tr class="tr1">
    <th>ID</th>
    <th>Nombre</th>
    <th>Eliminar</th>
    <th>Detalles</th>
    <th>Editar</th>
  </tr>
  <?php while($row = $res->fetch_array()) { ?>
    <tr class="tr1" id="row_<?php echo $row['id']; ?>">
      <td><?php echo $row["id"]; ?></td>
      <td><?php echo $row["nombre"]?></td>
      <td><a href="javascript:void(0);" onclick="eliminabanner(<?php echo $row['id']; ?>);">Eliminar</a></td>
      <td><a href="detalle_banners.php?id=<?php echo $row['id']; ?>">Ver detalle</a></td> 
      <td><a href="editar_banners.php?id=<?php echo $row['id']; ?>" class="btn btn-warning editar-administrador">Editar</a></td>

    </tr>
  <?php } ?>
</table>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
	function eliminabanner(id) {
		if (id && confirm("Estas seguro de eliminar el banner numero " + id + "?")) {
			$.ajax({
				url: 'banners_elimina.php',
				type: 'post',
				dataType: 'text',
				data: 'id=' + id,
				success: function(res) {
					if (res == 1) {
						eliminabannerTabla(id);
					}
				},
				error: function() {
					alert('Error: archivo no encontrado...');
				}
			});
		}
	}

	function eliminabannerTabla(id) {
		$('#row_' + id).hide();
	}
</script>

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