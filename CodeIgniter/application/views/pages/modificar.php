
<?php 
if(isset($vendedor)){
	echo validation_errors(); 
	$atributos = array('class' => 'form-horizontal', 'role'=>'form');
	echo form_open_multipart('http://localhost/CodeIgniter/index.php/catalogo/modificar/'.$producto['id_producto'], $atributos) 
?>
<div class="row col-xs-9">
<fieldset>

<? if(isset($error)) echo $error;?>
<? if(isset($exito)) echo $exito;?>
<!-- Form Name -->
<legend>Modificar producto</legend>
<input id="id" name="id" type="hidden" value="<?php echo $producto['id_producto']; ?>" class="form-control" >
<div class="row">
	<!-- Text input-->
	<div class="col-xs-5">
	  <label class="control-label" for="nombre">Nombre</label>
	  <div  class="controls">
		<input id="nombre" name="nombre" type="text" value="<?php echo $producto['nombre_producto']; ?>" class="form-control" >
		
	  </div>
	</div>
	<!-- Textarea -->
	<div class="col-xs-7">
	  <label class="control-label" for="descripcion">Descripción</label>
	  <div class="controls">                     
		<textarea id="descripcion" class="form-control"  name="descripcion" ><?php echo $producto['descripcion_producto']; ?></textarea>
	  </div>
	</div>

</div>

<div class="row">
	<!-- Select Basic -->
	<div class="col-xs-5">
	  <label class="control-label" for="categoria">Categoría</label>
	  <div class="controls">
		<select id="categoria" name="categoria" class="form-control" >
			<?php foreach ($categoria as $fila): 
				if($fila['id'] == $producto['fk_categoria_producto']){
			?>
				<option value="<?php echo $fila['id']; ?>" selected>
					<?php echo $fila['descripcion']; ?>
				</option>
			<?php
				} else {
			?>
				<option value="<?php echo $fila['id']; ?>">
					<?php echo $fila['descripcion']; ?>
				</option>
			<?php
				}
			?>
			
			<?php endforeach ?>
		</select>
	  </div>
	</div>

	<!-- Text input-->
	<div class="col-xs-4">
	  <label class="control-label" for="stock">Stock</label>
	  <div class="controls">
		<input id="stock" name="stock" type="text" value="<?php echo $producto['stock_producto']; ?>" class="form-control" >
		
	  </div>
	</div>
</div>

<div class="row">
	<!-- Text input-->
	<div class="col-xs-4">
	  <label class="control-label" for="precio_base">Precio base</label>
	  <div class="controls">
		<input id="precio_base" name="precio_base" type="text" value="<?php echo $producto['precio_producto']; ?>" class="form-control" >
		
	  </div>
	</div>

</div>
<div class="row">
	<!-- Select Basic -->
	<div class="col-xs-2">
	  <label class="control-label" for="iva">IVA aplicable</label>
	  <div class="controls">
		<select id="iva" name="iva" class="form-control" >
		<?php foreach ($iva as $fila): 
			if($fila['id'] == $producto['fk_iva_producto']){
		?>
			<option value="<?php echo $fila['id']; ?>" selected>
				<?php echo $fila['valor'].'%'; ?>
			</option>
		<?php
			}else{
		?>
			<option value="<?php echo $fila['id']; ?>">
				<?php echo $fila['valor'].'%'; ?>
			</option>
		<?php } ?>
		<?php endforeach ?>
		</select>
	  </div>
	</div>
</div>

<div class="row" style="float: right;">
		<input type="submit" name="submit" class="btn btn-primary" value="Guardar cambios" /> 

</div>

</fieldset>
</form>


<hr>

<?php 
	echo validation_errors(); 
	$atributos = array('class' => 'form-horizontal', 'role'=>'form');
	echo form_open_multipart('http://localhost/CodeIgniter/index.php/catalogo/cambiar_imagen/'.$producto['id_producto'], $atributos) 
?>

<fieldset>

<div class="row">
	<!-- File Button --> 
	<div class="col-xs-7">
	  <label class="control-label" for="imagen">Imagen</label>
	  <div class="controls">
		<input id="imagen" name="imagen" class="form-control" type="file">
	  </div>
	</div>
	<div class="col-xs-3">
		<img src="http://localhost/codeigniter/images/<?php echo $producto['id_producto']; ?>/1.jpg" style="width: 70px;">
	</div>
	<div class="row" style="float: left;">

		<input type="submit" name="submit" class="btn btn-primary" value="Cambiar imagen" /> 
	</div>
</div>

</fieldset>
</div>
</form>
<?php 
}
?>