<?php
//Variable para saber si el pedido está listo para ser enviado (stock ok)
$listo = FALSE;

if ($this->cart->total_items()) {

	$this->table->set_heading('#','Nombre', 'Categoría','Precio', 'Cantidad', 'IVA', 'Subtotal', 'Eliminar');

	$totalConIVA = 0;
	
	foreach ($productos as $producto) {

		//Acceso al array de opciones de cada producto.
		$opciones = $this->cart->product_options($producto['rowid']);
		$iva = $this->iva_model->get_iva($opciones['IVA']);
		$cat = $this->categoria_model->get_categoria($opciones['Cat.']);

		//Filas de la tabla del carrito
		$precioConIVA = $producto['price']*(1+($iva['valor']/100));

		$this->table->add_row(
								$producto['id'],

								$producto['name'],

								$cat['descripcion'],

								'<div class="text-right">'.$precioConIVA.'€'.'</div>', 

								'<div class="text-center">
								 <a class="text-danger" href="http://localhost/CodeIgniter/index.php/carrito_control/menos1/'.$producto['rowid'].'/'.$producto['qty'].'"><strong>- </strong></a>'
								.$producto['qty'].
								'<a class="text-success" href="http://localhost/CodeIgniter/index.php/carrito_control/mas1/'.$producto['rowid'].'/'.$producto['qty'].'"><strong> +</strong></a>
								</div>',

								$iva['valor'].'%',

								'<div class="text-center">'.
								$producto['qty']*$precioConIVA.'€ </div>',

								'<div class="text-center"> <a class="text-danger" href="http://localhost/CodeIgniter/index.php/carrito_control/eliminar/'.$producto['rowid'].'">✘</a></div>'
							);
		$totalConIVA+= $producto['qty']*$precioConIVA;
	}

	//Estilos para la tabla del carrito.
	$plantilla = array ( 'table_open'  => '<table id="tabla_carrito" class="table table-hover table-condensed">' );
	$this->table->set_template($plantilla);

	//Pintar la tabla
	echo $this->table->generate();

	//Esto aquí es una pequeña chapucilla :(
	if (isset($todo_ok)) { $listo = TRUE; }
	
	$pie_tabla = array( 
						array(
								'<button type="button" class="btn btn-default">Cantidad total : <strong>'. 
								 $this->cart->total_items().' ud(s)</strong></button>',

								 '<button type="button" class="btn btn-default">Importe total : <strong>'. 
								 $totalConIVA .'€'.'</strong></button>',

								'<form action="http://localhost/CodeIgniter/index.php/carrito_control/vaciar">
									<input type="submit" class="btn btn-warning" value="Vaciar carrito">
								</form>',

								//Esto es un if en una sentencia
								$listo
								?'<form action="http://localhost/CodeIgniter/index.php/pedido_control/enviar_pedido">
									<input type="submit" class="btn btn-success" value="Enviar pedido">
								</form>'
								:'<form action="http://localhost/CodeIgniter/index.php/carrito_control/comprobar">
									<input type="submit" class="btn btn-primary" value="Comprobar pedido">
								</form>'
								
							)
					);

	echo $this->table->generate($pie_tabla);

	//Todo esto debajo de la tabla para que no se esté moviendo constantemente


	if (isset($agregado)) {
		echo '<div class="bs-callout bs-callout-info">';
		echo '<p>'.$agregado.'</p>';
		echo '</div>';
	}
	if (isset($eliminado)) {
		echo '<div class="bs-callout bs-callout-danger">';
		echo '<p>'.$eliminado.'</p>';
		echo '</div>';
	}
	if (isset($todo_ok)) {
		echo '<div class="bs-callout bs-callout-info">';
		echo '<p class="text-success">'.$todo_ok.'</p>';
		echo '</div>';
	}
	if (isset($problema)) {
		echo '<div class="bs-callout bs-callout-danger">';
		echo '<p>'.$problema.'</p>';
		foreach ($stocks as $stock) {
			echo '<p><ul>';
			echo '<li>De <strong>'.$stock["tit"].'</strong> solo tenemos <strong>'. $stock["sto"] . ' unidad'. ($stock["sto"]>1?'es. ':'. ') . '</strong></li>';
			echo '</ul></p>';
		}
		echo '<div class="text-right">';
		echo '<form action="http://localhost/CodeIgniter/index.php/carrito_control/arreglar/">';
		echo '<input type="submit" class="btn btn-info" value="Arréglalo">';
		echo '</form>';
		echo '</div></div>';
	}

} else {
	echo '<div class="bs-callout bs-callout-warning">';
	echo '<h4>Carrito vacío.</h4><br>';
	echo '¿A qué estás esperando? ';
	echo 'visita <a href="http://localhost/CodeIgniter/index.php/catalogo">nuestro catálogo</a> ahora y cómprate algo bonito.';
	echo '</div>';
}



?>