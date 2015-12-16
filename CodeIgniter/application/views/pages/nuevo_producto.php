
<?php 

if(isset($vendedor)){
	echo validation_errors(); 
	$atributos = array('class' => 'form-horizontal', 'role'=>'form');
	echo form_open_multipart('http://localhost/CodeIgniter/index.php/catalogo/insertar_producto', $atributos) 
?>
<fieldset>

<!-- Form Name -->
<legend>Nuevo producto</legend>

<div class="row">
	<!-- Text input-->
	<div class="col-xs-5">
	  <label class="control-label" for="nombre">Nombre</label>
	  <div  class="controls">
		<input id="nombre" name="nombre" type="text" placeholder="Nombre del producto" class="form-control" >
		
	  </div>
	</div>
	<!-- Textarea -->
	<div class="col-xs-7">
	  <label class="control-label" for="descripcion">Descripción</label>
	  <div class="controls">                     
		<textarea id="descripcion" class="form-control"  name="descripcion"></textarea>
	  </div>
	</div>

</div>

<div class="row">
	<!-- Select Basic -->
	<div class="col-xs-5">
	  <label class="control-label" for="categoria">Categoría</label>
	  <div class="controls">
		<select id="categoria" name="categoria" class="form-control" >
			<?php foreach ($categoria as $fila): ?>
				<option value="<?php echo $fila['id']; ?>">
					<?php echo $fila['descripcion']; ?>
				</option>
			<?php endforeach ?>
		</select>
	  </div>
	</div>

	<!-- Text input-->
	<div class="col-xs-4">
	  <label class="control-label" for="stock">Stock</label>
	  <div class="controls">
		<input id="stock" name="stock" type="text" placeholder="Stock disponible" class="form-control" >
		
	  </div>
	</div>
</div>

<div class="row">
	<!-- Text input-->
	<div class="col-xs-4">
	  <label class="control-label" for="precio_base">Precio base</label>
	  <div class="controls">
		<input id="precio_base" name="precio_base" type="text" placeholder="Precio base del producto" class="form-control" >
		
	  </div>
	</div>

</div>
<div class="row">
	<!-- Select Basic -->
	<div class="col-xs-2">
	  <label class="control-label" for="iva">IVA aplicable</label>
	  <div class="controls">
		<select id="iva" name="iva" class="form-control" >
		<?php foreach ($iva as $fila): ?>
		  <option value="<?php echo $fila['id']; ?>"><?php echo $fila['valor'].'%'; ?></option>
		<?php endforeach ?>
		</select>
	  </div>
	</div>
</div>
<div class="row">
	<!-- File Button --> 
	<div class="col-xs-7">
	  <label class="control-label" for="imagen">Imagen</label>
	  <div class="controls">
		<input id="imagen" name="imagen" class="form-control" type="file">
	  </div>
	</div>
</div>
</fieldset>
<br>
<div class="row" style="float: right;">
		<input type="submit" name="submit" class="btn btn-primary" value="Enviar producto" /> 

</div>
</form>

<? if(isset($mensaje)) echo $mensaje;?>
<?php
}
?>