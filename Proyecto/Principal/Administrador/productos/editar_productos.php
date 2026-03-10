<?php
//editar_administrador.php
require "Funciones/conecta.php";
$con = conecta();

// Obtener el ID del administrador de la URL
$id = $_GET['id'];

// Obtener los datos del administrador de la base de datos
$sql = "SELECT * FROM productos WHERE id = $id";
$res = $con->query($sql);
$row = $res->fetch_array();
?>

<body>
<?php include 'menuprod.php'; ?>
<form id="formulario" action="productos_salva_actualiza.php" method="POST" enctype="multipart/form-data"> 
    <h1>Edicion de productos</h1>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo $row['nombre']; ?>">
    <br><br>
    <label for="codigo">Codigo:</label>
    <input name="codigo" id="codigo" value="<?php echo $row['codigo']; ?>">
    <div id="mensaje_codigo" style="color: red;"></div>
    <br><br>
    <label for="costo">Costo:</label>
    <input name="costo" id="costo" value="<?php echo $row['costo']; ?>">
    <br><br>
    <label for="stock">Stock:</label>
    <input name="stock" id="stock"value="<?php echo $row['stock']; ?>">
    <br><br>
    <label for="descripcion">Descripcion:</label>
    <input type="text" name="descripcion" id="descripcion" value="<?php echo $row['descripcion']; ?>">
    <br><br>
    <label for="archivo">Foto:</label>
    <input type="file" name="archivo" id="archivo">
    <br><br>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name="Salvar" value="Salvar">
    <a href="productos_lista.php">Regresar al listado</a>
    <div id="error" style="color: red;"></div>

  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
  $("#formulario").submit(function(event) {
    // Prevent the form from submitting
    event.preventDefault();

    // Check if all required fields are filled
    if ($("#nombre").val() === "" || $("#codigo").val() === "" || $("#costo").val() === "" || $("#stock").val() === "" || $("#descripcion").val() === "") {
      $("#error").text("Por favor, complete todos los campos.");
      setTimeout(function() {
        $("#error").text("");
      }, 5000); // Borrar mensaje después de 5 segundos
      return;
    }

    // Send an AJAX request to check if the code already exists in the database only if the code is modified
    if ($("#codigo").val() !== "<?php echo $row['codigo']; ?>") {
      $.ajax({
        url: "verificar_codigo.php",
        type: "POST",
        data: {
          codigo: $("#codigo").val()
        },
        success: function(response) {
          if (response === "existe") {
            $("#mensaje_codigo").text("Este código ya existe en la base de datos.");
            setTimeout(function() {
              $("#mensaje_codigo").text("");
            }, 5000); // Borrar mensaje después de 5 segundos
          } else {
            // Submit the form if the code doesn't exist in the database
            $("#formulario")[0].submit();
          }
        }
      });
    } else {
      // Submit the form if the code is not modified
      $("#formulario")[0].submit();
    }
  });
});

 </script>

<style>
  #mensaje_codigo {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: center;
  background-color: #f2f2f2;
  margin-top: 10px;
}

  #error {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: center;
  background-color: #f2f2f2;
  margin-top: 20px;
  }
  form {
    margin: 20px auto;
    width: 50%;
    border: 1px solid #ddd;
    padding: 20px;
  }

  label {
    display: inline-block;
    width: 100px;
    margin-bottom: 10px;
  }
  input[name="codigo"],
  input[name="costo"],
  input[name="stock"],
  input[type="text"],
  select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
  }

  input[type="submit"] {
    background-color: #0066cc;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #0051a8;
  }

  #error {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: center;
    background-color: #f2f2f2;
    margin-top: 20px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
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
    text-align: left;
    background-color: #f5f5f5;
  }

  a {
    color: #0066cc;
  }

  a:hover {
    text-decoration: underline;
  }
  </style>
</body>

