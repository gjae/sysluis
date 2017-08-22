{{ csrf_field() }}
<input type="hidden" name="accion" value="nuevo" id="accion">
<div class="col-sm-4">
<<<<<<< HEAD
	<label for="descripcion_razon">Nombre de la razón</label>
	<input type="text" value="" name="descripcion_razon" id="descripcion_razon" class="form-control">
</div>
<div class="col-sm-4">
	<label for="codigo_razon">Código de la razón</label>
	<input type="text" name="codigo_razon" value="" id="codigo_razon" class="form-control">
=======
	<label for="descripcion_razon">Nombre de la razon</label>
	<input type="text" onkeyup="soloTexto(event, this, 80)" onkeydown="soloTexto(event, this, 80)" value="" name="descripcion_razon" id="descripcion_razon" class="form-control">
</div>
<div class="col-sm-4">
	<label for="codigo_razon">Codigo de la razon</label>
	<input type="text" onkeyup="textoYNumero(event, this, 6)" name="codigo_razon" value="" id="codigo_razon" class="form-control">
>>>>>>> 6980015e514d1685fd039cf8eeda13a228337a82
</div>

<div class="row">
	<div class="col-sm-8">
		<label for="explicacion_razon">Justificación</label>
		<textarea name="explicacion_razon" id="explicacion_razon" class="form-control" cols="30" rows="10"></textarea>
	</div>
</div>
