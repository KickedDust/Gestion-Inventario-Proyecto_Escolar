<?php
//productos_lista.php
require "Funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);
?>
 <?php include 'menuprod.php'; ?>
<table class="table">
  <th colspan="9">
    <h1>Listado de productos</h1>
  </th>
  <tr class="tr1"><td colspan="9"><a href = "form_admin.php" class="btn btn-primary mb-3">Crear nuevo producto</a></td></tr>
  <tr class="tr1">
    <th>ID</th>
    <th>Nombre</th>
    <th>Codigo</th>
    <th>Costo</th>
    <th>Stock</th>
    <th>Descripcion</th>
    <th>Eliminar</th>
    <th>Detalles</th>
    <th>Editar</th>
  </tr>
  <?php while($row = $res->fetch_array()) { ?>
    <tr class="tr1" id="row_<?php echo $row['id']; ?>">
      <td><?php echo $row["id"]; ?></td>
      <td><?php echo $row["nombre"]?></td>
      <td><?php echo $row["codigo"]; ?></td>
      <td><?php echo $row["costo"]; ?></td>
      <td><?php echo $row["stock"]; ?></td>
      <td><?php echo $row["descripcion"]; ?></td>
      <td><a href="javascript:void(0);" onclick="eliminaProducto(<?php echo $row['id']; ?>);">Eliminar</a></td>
      <td><a href="detalle_productos.php?id=<?php echo $row['id']; ?>">Ver detalle</a></td> 
      <td><a href="editar_productos.php?id=<?php echo $row['id']; ?>" class="btn btn-warning editar-administrador">Editar</a></td>

    </tr>
  <?php } ?>
</table>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
	function eliminaProducto(id) {
		if (id && confirm("Estas seguro de eliminar el Producto numero " + id + "?")) {
			$.ajax({
				url: 'productos_elimina.php',
				type: 'post',
				dataType: 'text',
				data: 'id=' + id,
				success: function(res) {
					if (res == 1) {
						eliminaProductoTabla(id);
					}
				},
				error: function() {
					alert('Error: archivo no encontrado...');
				}
			});
		}
	}

	function eliminaProductoTabla(id) {
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