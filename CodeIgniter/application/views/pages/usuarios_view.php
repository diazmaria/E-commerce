<html>
	<head>
		<meta charset="utf-8">
		<title>Registrar usuario</title>
        <link href= "http://localhost/CodeIgniter/bootstrap.css" rel="stylesheet" type="text/css">
	</head>


	<body>
		<?php

		

        $br = '<br><br>';
        $esp = '&nbsp';
            echo form_open('http://localhost/CodeIgniter/index.php/usuarios/very_sesion');

            echo form_label('Usuario', 'usuario').$esp;
            echo form_input('usuario', set_value('usuario')).$br;

            echo form_label('Contraseña', 'contrasena').$esp;
            echo form_password('contrasena', set_value('contrasena')).$br;

            echo form_submit('submit', 'Enviar');
            echo form_close();

            echo '<a href = "http://localhost/CodeIgniter/index.php/usuarios/registro" title="Deseo registrarme"> Registrarme </a>';
        
             echo'<b><br><div id="validacion">';
			 
             echo validation_errors();
                if (isset($error))
                {
                    echo $error;
                }
            echo '</div>';
        ?>
	</body>
</html>