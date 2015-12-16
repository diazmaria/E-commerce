
 <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://localhost/CodeIgniter/index.php/catalogo">Tienda PW</a>
        </div>
        <div class="collapse navbar-collapse" style="float:left;">
			<ul class="nav navbar-nav">
				<li><a href="http://localhost/CodeIgniter/index.php/catalogo">Inicio</a></li>
				<?php 

				if (isset($usuario))
				{
					echo '<li><a href="http://localhost/CodeIgniter/index.php/panel/">Mis datos</a></li>';
					
					echo '<li><a href="http://localhost/CodeIgniter/index.php/carrito_control/">Carrito</a></li>';
					echo '<li><a href="http://localhost/CodeIgniter/index.php/pedido_control/">Pedidos</a></li>';
					echo '<li><a href=http://localhost/CodeIgniter/index.php/usuarios/abandonar_sesion>Abandonar sesión</a></li>';
				}
	

				else if (isset($vendedor))
				{
					echo '<li ><a href="http://localhost/CodeIgniter/index.php/catalogo/insertar_producto" >Nuevo producto</a></li>';
					echo '<li><a href=http://localhost/CodeIgniter/index.php/usuarios/abandonar_sesion>Abandonar sesión</a></li>';
				}

				else
				{
					echo '<li><a href="http://localhost/CodeIgniter/index.php/usuarios/">Iniciar sesión</a></li>';
					echo '<li><a href="http://localhost/CodeIgniter/index.php/usuarios/registro/">Registrarse</a></li>';
				}	


			  ?>
			</ul>
          </div><!-- /.nav-collapse -->
   </div><!-- /.container -->
    </div><!-- /.navbar -->