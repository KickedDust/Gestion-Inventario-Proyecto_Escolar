<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
$(document).ready(function() {
  $('form').submit(function(event) {
    var error = false;
    $('input[type="text"], input[type="email"], input[type="password"], select').each(function() {
      if ($(this).val() === '') {
        $(this).css('border', '1px solid red');
        error = true;
      } else {
        $(this).css('border', '');
      }
    });
    if (error) {
      event.preventDefault();
      $('#error').text('Faltan campos por llenar');
      setTimeout(function() {
        $('#error').text('');
      }, 5000);
    } else {
      var correo = $('#correo').val();
      $.ajax({
        url: 'valida_correo.php',
        type: 'POST',
        data: { correo: correo },
        success: function(response) {
          if (response === 'existe') {
            event.preventDefault();
            $('#correo_error').text('El correo ya existe en la base de datos');
            setTimeout(function() {
            $('#correo_error').text('');
            }, 5000);
          } else {
            $('#correo_error').text('');
            $('form').unbind('submit').submit();
          }
        },
        error: function() {
          alert('Error al validar correo');
        }
      });
      event.preventDefault();
    }
  });
  });
  </script>
</head>
<body>
    <form id="formulario" action="administradores_salva.php" method="POST" enctype="multipart/form-data">
    <h1>Alta de administradores</h1>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">
    <br><br>
    <label for="apellidos">Apellidos:</label>
    <input type="text" name="apellidos" id="apellidos">
    <br><br>
    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo">
    <div id="correo_error" style="color: red;"></div>
    <br><br>
    <label for="pass">Contraseña:</label>
    <input type="password" name="pass" id="pass">
    <br><br>
    <label for="rol">Rol:</label>
    <select name="rol" id="rol">
      <option value="1">Gerente</option>
      <option value="0">Ejecutivo</option>
    </select>
    <br><br>
    <label for="archivo">Foto:</label>
    <input type="file" name="archivo" id="archivo">
    <br><br>
    <input type="submit" name="Salvar" value="Salvar">
    <a href="administradores_lista.php">Regresar al listado</a>
    <div id="error" style="color: red;"></div>
  </form>
</body>


  <style>
  #correo_error {
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