<html>
	<head>
		<meta charset="utf-8">
		<title></title>
        <link href= "http://localhost/CodeIgniter/bootstrap.css" rel="stylesheet" type="text/css">
	</head>
	<body><br><br><br>

<?php

if (isset($mensaje))
{
	echo "<h4 color ='green'>".$mensaje."</h4>";
}

  echo '<a href = "http://localhost/CodeIgniter/index.php/usuarios/abandonar_sesion" title="Deseo cerrar mi sesión"> Cerrar Sesión </a>';

?>
</body>
</html>