{{ csrf_field() }}
<input type="hidden" name="accion" value="nuevo" id="accion">
<div class="col-sm-4">
	<label for="descripcion_razon">Nombre de la razon</label>
	<input type="text" value="" name="descripcion_razon" id="descripcion_razon" class="form-control">
</div>
<div class="col-sm-4">
	<label for="codigo_razon">Codigo de la razon</label>
	<input type="text" name="codigo_razon" value="" id="codigo_razon" class="form-control">
</div>

<div class="row">
	<div class="col-sm-8">
		<label for="explicacion_razon">Justificacion</label>
		<textarea name="explicacion_razon" id="explicacion_razon" class="form-control" cols="30" rows="10"></textarea>
	</div>
</div>
