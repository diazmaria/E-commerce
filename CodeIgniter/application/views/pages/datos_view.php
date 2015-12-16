<html>
	<head>
		<meta charset="utf-8">
		<title>Registrar usuario</title>
        <link href= "http://localhost/CodeIgniter/bootstrap.css" rel="stylesheet" type="text/css">
	</head>

	<body>

    <br><br><br><br>
		<h4 align="center">Datos del usuario <?php echo "<b>".$usuario."</b>"; ?></h4>
        <br>

		<?php
		if (isset($mensaje))
		{
		  echo $mensaje;
		}

        $br = '<br><br>';
        $esp = '&nbsp';

            echo form_open('http://localhost/CodeIgniter/index.php/panel/datos_very'); echo"<br>";

            echo form_label('Nombre', 'nombre').$esp;
            echo form_input('nombre', set_value('nombre', $nombre)).$br;  

            echo form_label('Apellidos', 'apellidos').$esp;
            echo form_input('apellidos', set_value('apellidos', $apellidos)).$br;  

             echo form_label('DNI', 'dni').$esp;
             echo form_input('dni', set_value('dni', $dni)).$br;  

         	echo form_label('Dirección', 'direccion').$esp;
            echo form_input('direccion', set_value('direccion', $direccion)).$br;

            echo form_label('Fecha de nacimiento(aaaa-mm-dd)', 'fecha_nacimiento').$esp;
            echo form_input('fecha_nacimiento', set_value('fecha_nacimiento', $fecha_nacimiento)).$br;

            echo form_label('Teléfono', 'telefono');
            echo form_input('telefono', set_value('telefono', $telefono));

            echo form_label('Correo', 'correo').$esp;
            echo form_input('correo', set_value('correo', $correo)).$br;

            echo form_label('Contraseña', 'contrasena').$esp;
            echo form_input('contrasena', set_value('contrasena', $contrasena)).$br;

            echo form_submit('submit_datos', 'Enviar');

            echo '<a href = "http://localhost/CodeIgniter/index.php/panel/borrar" title="Deseo darme de baja"> Borrar cuenta </a>';

            echo form_close();
        ?>
            <b><div id="validacion">
		      <?= validation_errors(); ?>
            </div></b>
	</body>
</html>