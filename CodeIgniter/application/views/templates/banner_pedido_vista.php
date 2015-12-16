 <p class="pull-left visible-xs">
    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle Nav</button>
</p>
    <div class="jumbotron">
        <h3><?php echo $title ?></h3>
        <p>
        <?php
        	if (isset($usuario)) {
        		echo 'Hola '. $usuario.'. ';
        	}
        	if (isset($vendedor)) {
        		echo 'Hola '. $vendedor.'. ';
        	}

        echo '<small>'.$mensaje.'</small>' ?></p>
        <ol>
        	<li>Muchas cosas por hacer aquí. Después sigo...</li>
        </ol>
    </div>