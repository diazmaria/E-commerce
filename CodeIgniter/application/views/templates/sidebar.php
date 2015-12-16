

      <div class="row row-offcanvas row-offcanvas-left">
        
         <div class="col-xs-12 col-sm-3 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
           <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"></button>
          </p>
          <div class="well sidebar-nav">
			<div class="row">
				<?php 
				echo validation_errors(); 
				$atributos = array('class' => 'navbar-form navbar-left', 'role'=>'form');
				echo form_open_multipart('http://localhost/CodeIgniter/index.php/catalogo/validar_busqueda', $atributos) 
				?>
				<fieldset>
						<div>
							<div class="input-group">
							  <input type="text" class="form-control" name="buscar">
							  <span class="input-group-btn">
								<input type="submit"  class="btn btn-default" value="Buscar">
							  </span>
							</div><!-- /input-group -->
						  </div><!-- /.col-lg-6 -->
					</form>
				</fieldset>
				<?php
					echo form_close();
				?>
			</div>
            <ul class="nav">
              <li>Menú</li>
			  <?php foreach ($menuSideBar as $fila): ?>
			  <li class=""><a href="http://localhost/codeigniter/index.php/catalogo/buscar_categoria/<?php echo $fila['id'] ?>/pages/0"><?php echo $fila['descripcion'] ?></a></li>
			  <?php
			  endforeach
			  ?>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->