<?php
require "Funciones/conecta.php";
$con = conecta();

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sql = "SELECT nombre, archivo FROM banners WHERE id = $id";
  $res = $con->query($sql);
  $row = $res->fetch_array();
    
  if ($row) {
    $archivo = $row["archivo"];
  }
}
?>

<body>
<?php include 'menubann.php'; ?>
<form id="formulario" action="banners_salva_actualiza.php" method="POST" enctype="multipart/form-data"> 
    <h1>Edicion de banners</h1>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo $row['nombre']; ?>">
    <br><br>
    <label for="archivo">Foto:</label>
    <input type="file" name="archivo" id="archivo">
    <br><br>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name="Salvar" value="Salvar">
    <a href="banners_lista.php">Regresar al listado</a>
    <div id="error" style="color: red;"></div>

  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
  $("#formulario").submit(function(event) {
    if ($("#nombre").val() === "") {
      event.preventDefault();
      $("#error").text("Por favor, complete todos los campos.");
      setTimeout(function() {
        $("#error").text("");
      }, 5000); // Borrar mensaje después de 5 segundos
      return;
    }
  });
});
  </script>

<style>
  #mensaje_codifo {
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

  input[type="text"],
  input[type="email"],
  input[type="password"],
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

