<?php

//Ahora construiré una tabla que muestre todos los pedidos almacenados en $ventas
$this->table->set_heading('#','Fecha', 'Importe total','Estado', 'Detalles');
$i = 0;
//Después de los encabezados de la tabla vienen las filas
foreach ($ventas as $pedido) {

	$estado = $this->estado_model->get_estado($pedido['fk_estado']);

	$this->table->add_row(
							$pedido['id'],

							$pedido['fecha'],
							
							$pedido['total'].'€',

							'<div>'.
							$estado['descripcion'].
							'</div>', 

							'<a class="text-info" href="http://localhost/CodeIgniter/index.php/pedido_control/detalles/'.$pedido['id'].'">ver detalles</a>'
						);
	$i++;
}

//estilos para la tabla
$plantilla = array ( 'table_open'  => '<table id="tabla_pedidos" class="table table-hover table-condensed">' );
$this->table->set_template($plantilla);

if($i){
	echo $this->table->generate();
}

?>