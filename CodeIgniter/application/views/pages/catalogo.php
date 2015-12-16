
        <div class="col-xs-12 col-sm-9 col-md-9">
         
          <div class="row row-offcanvas row-offcanvas-left">
			<?php foreach ($productos as $fila): ?>
				<div class="col-xs-12 col-sm-6 col-md-4 bs-callout bs-callout-info" >
                    <div style="height:420px;">
                        <h4><a href="http://localhost/CodeIgniter/index.php/catalogo/detalles/<?php echo $fila['id_producto'] ?>"><?php echo $fila['nombre_producto'] ?></a></h4>
						
						<?php $precioConIva = $fila['precio_producto']+($fila['valor_iva']* $fila['precio_producto'])/100; ?>
						
                        <h5><?php echo "Precio: ".$precioConIva."&euro;" ?></h5>
                        
                        <div style="height:160px;">
                        	<img  src="/CodeIgniter/images/<?php echo $fila['id_producto']?>/1.jpg"  style="width: 100px;">
                        </div>
                        <div style="height:120px;">
                            <p><?php echo substr($fila['descripcion_producto'], 0, 160)."..." ?></p>
                         </div> 
                        
                            <h4><?php echo "Stock: ".$fila['stock_producto'] ?></h4>
                        
                        <p>
                            <a class="btn btn-default" href="http://localhost/CodeIgniter/index.php/catalogo/detalles/<?php echo $fila['id_producto'] ?>" role="button">Ver detalles &raquo;</a>
							<?php 
								if($fila['stock_producto'] >=1){
							?>
									<a class="btn btn-primary" href="http://localhost/CodeIgniter/index.php/carrito_control/anhadir/<?php echo $fila['id_producto'] ?>" role="button">Añadir al carrito</a>
							<?php
								} else {
							?>
								<button  class="btn btn-warning">Sin stock</button>
							<?php
								}
							?>
                        </p>
                    </div>
				</div><!--/span-->
			<?php endforeach ?>
			
          </div><!--/row-->
		  <div class="row">
		  <?=$this->pagination->create_links()?>  
		  </div>
        </div><!--/span-->

        

