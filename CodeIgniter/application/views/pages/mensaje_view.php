<html>
	<head>
		<meta charset="utf-8">
		<title></title>
        <link href= "http://localhost/CodeIgniter/bootstrap.css" rel="stylesheet" type="text/css">

        <script language="Javascript">

		function redireccionar() {
		setTimeout("location.href='http://localhost/CodeIgniter/index.php/catalogo'", 1000);
		}

		</script>


		<script>
			function goBack()
			  {
			  window.history.go(-1)
			  }
		</script>

	</head>
	<body onload="redireccionar()">

<?php

if (isset($mensaje))
{
	echo "<h1>".$mensaje."</h1>";
}

?>
</body>
</html>