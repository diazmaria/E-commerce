<div>

 <div class="col-xs-12 col-md-9 col-sm-9 bs-callout bs-callout-info">
         
    <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12" >
			<h2><?php echo $producto['nombre_producto'] ?></h2>
			<?php $precioConIva = $producto['precio_producto']+($producto['valor_iva']* $producto['precio_producto'])/100; ?>
			<h4><?php echo "Precio: ".$precioConIva."&euro;" ?></h4>
			<div style="float:left; margin-right:10px">
				<img  src="/CodeIgniter/images/<?php echo $producto['id_producto']?>/1.jpg"  style="width: 200px;">
			</div>	
			<div style="float:rigth;">
				<?php echo $producto['descripcion_producto']; ?>
						
			</div>
			<h3><?php echo "Stock: ".$producto['stock_producto'] ?></h3>
			<p><?php 
								if($producto['stock_producto'] >=1){
							?>
									<a class="btn btn-primary" href="http://localhost/CodeIgniter/index.php/carrito_control/anhadir/<?php echo $producto['id_producto'] ?>" role="button">Añadir al carrito</a>
							<?php
								} else {
							?>
								<button  class="btn btn-warning">Sin stock</button>
							<?php
								}
							?>
				<?php 
					if(isset($vendedor)){
				?>
						<a class="btn btn-link" href="http://localhost/codeigniter/index.php/catalogo/modificar/<?php echo $producto['id_producto']; ?>" role="button">Modificar</a>
				<?php
					}
				?>
			</p>
		</div><!--/span-->
	</div>
</div>



</div>

