<?php

	$this->table->set_heading('#','Nombre','Precio', 'Cantidad', 'Subtotal');
	
	$totalConIVA = 0;

	foreach ($lineas as $linea) {

		$producto = $this->catalogo_model->get_catalogo($linea['fk_producto']);
		$iva = $this->iva_model->get_iva($producto['fk_iva']);
		$precioConIVA = $producto['precio_base']*(1+($iva['valor']/100));

		//añadimos las filas a la table
		$this->table->add_row(
								$producto['id'],

								$producto['nombre'],

								'<div class="text-center">'.$precioConIVA.'€'.'</div>', 

								'<div class="text-center">'.
								$linea['cantidad']. '</div>',

								'<div class="text-center">'.
								$linea['cantidad']*$precioConIVA.'€ </div>'
							);

		$totalConIVA+= $linea['cantidad']*$precioConIVA;
	}

	//Estilos para la tabla del carrito.
	$plantilla = array ( 'table_open'  => '<table id="tabla_carrito" class="table table-hover table-condensed">' );
	$this->table->set_template($plantilla);

	//Pintar la tabla
	echo $this->table->generate();

?>
<form action="http://localhost/CodeIgniter/index.php/pedido_control/">
	<input type="submit" class="btn btn-default" value="Atrás">
</form>