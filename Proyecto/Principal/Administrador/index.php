<?php
session_start();
if(isset($_SESSION["id"])){
	header("Location: bienvenido.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
<style>
  body {
    background-color: #f2f2f2;
	display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  }

  header {
    color: black;
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
  }

  form {
    text-align: center;
    margin: 20px auto;
    width: 50%;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 0 10px #ddd;
  }

  table {
    margin: auto;
    border-collapse: collapse;
    width: 100%;
  }

  td {
    padding: 12px;
    text-align: ;
    font-size: 16px;
    color: #053972;
    border-bottom: 1px solid #ddd;
  }

  input[type="email"],
  input[type="password"] {
    padding: 8px;
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
    margin-bottom: 10px;
    color: black; 
  }

  input[type="button"] {
    background-color: #008CBA;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }

  input[type="button"]:hover {
    background-color: #0077a7;
  }

  #mensaje {
    background-color: #f44336;
    color: white;
    padding: 10px;
    margin-bottom: 15px;
    text-align: center;
    border-radius: 4px;
    display: none;
  }
  a{
    color: red;
  }
</style>

</head>
<body>

    <form name="forma01">
      <table>
	  <header>
		<h1>Login</h1>
	  </header>
        <tr>
          <td>Correo:</td>
          <td><input type="email" id="correo" name="correo"  required></td>
        </tr>
        <tr>
          <td >Contraseña:</td>
          <td><input type="password" id="pass" name="pass"  required></td>
        </tr>
        <tr>
		<td colspan="2"><input onClick="recibe();" type="button" value="Ingresar"><br>
    <a href="../principal.php?">Regresar a Home</a>
		<div id="mensaje" hidden>Faltan campos por llenar</div>
        </tr>
		
      </table>
	  
    </form>


	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script type="text/javascript">
	var valido = false;

  	function ejecutaAjax() {
  			var user = $('#correo').val();
			var pass = $('#pass').val();
			
			if (correo) {
				$.ajax({
					url			: 'validar_login.php',
					type		: 'post',
					dataType	: 'text',
					data 		: 'correo='+correo+'&pass='+pass,
					success		: function(res) {
						if (res == 0) {
							reDirect();
						}
						else{
							alert("DATOS INCORRECTOS");
						}
					},
					error 		: function() {
						alert('Error archivo no encontrado...');
					}
				});

			}
	}
	function reDirect() {
		location.href = 'bienvenido.php';
	}

	function recibe(){
  		correo = document.forma01.correo.value;
  		pass = document.forma01.pass.value;
  		datosCorrectos = true;

		if (!(/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(correo))) {
			$('#mensaje').show();
  			setTimeout("$('#mensaje').hide()",5000);
			datosCorrectos = false;
		}
		else if (pass == null || pass.length == 0 || /^\s+$/.test(pass) ) {
			$('#mensaje').show();
  			setTimeout("$('#mensaje').hide()",5000);
			datosCorrectos = false;
		}

		if (datosCorrectos) {
			ejecutaAjax();
		}
  	}
</script>

</body>
</html>