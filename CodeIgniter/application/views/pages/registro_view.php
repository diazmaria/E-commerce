<html>
	<head>
		<meta charset="utf-8">
		<title>Registrar usuario</title>
        <link href= "http://localhost/CodeIgniter/bootstrap.css" rel="stylesheet" type="text/css">
	</head>

	<body>



		<?php
		if (isset($mensaje))
		{
		  echo $mensaje;
		}

        $br = '<br><br>';
        $esp = '&nbsp';
		
            echo form_open('http://localhost/CodeIgniter/index.php/usuarios/registro_very');

            echo form_label('Nombre', 'nombre').$esp;
            echo form_input('nombre', set_value('nombre')).$br;

            echo form_label('Apellidos', 'apellidos').$esp;
            echo form_input('apellidos', set_value('apellidos')).$br;  

            echo form_label('DNI', 'dni').$esp;
            echo form_input('dni', set_value('dni')).$br;  

     		echo form_label('Dirección', 'direccion').$esp;
            echo form_input('direccion', set_value('direccion')).$br;

            echo form_label('Fecha de nacimiento(aaaa-mm-dd)', 'fecha_nacimiento').$esp;
            echo form_input('fecha_nacimiento', set_value('fecha_nacimiento')).$br;

            echo form_label('Teléfono', 'telefono').$esp;
            echo form_input('telefono', set_value('telefono')).$br;

            echo form_label('Correo', 'correo').$esp;
            echo form_input('correo', set_value('correo')).$br;

            echo form_label('Usuario', 'usuario').$esp;
            echo form_input('usuario', set_value('usuario')).$br;

            echo form_label('Contraseña', 'contrasena').$esp;
            echo form_password('contrasena', set_value('contrasena')).$br;

            echo form_submit('submit_reg', 'Enviar');
            echo form_close();

            echo '<a href = "http://localhost/CodeIgniter/index.php/usuarios" title="Deseo iniciar sesión"> Iniciar Sesión </a>';
        ?>
            <b><br><div id="validacion">
		      <?= validation_errors(); ?>
            </div></b>
	</body>
</html>