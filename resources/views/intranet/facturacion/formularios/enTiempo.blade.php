
<div class="row">
	
	<div class="col-sm-4">
		
		<label for="fecha_desde">Fecha desde (FORMATO AAAA-MM-DD)</label>
		<input type="date"  class="form-control" name="fecha_desde" id="fecha_desde">

	</div>
	<div class="col-sm-4">
		
		<label for="fecha_hasta">Fecha hasta (FORMATO AAAA-MM-DD)</label>
		<input type="date"  class="form-control" name="fecha_hasta" id="fecha_hasta">

	</div>
	
	<div class="col-sm-6">
		<p>
			Esta modalidad emitira un archivo PDF con los detalles básicos de
			cada facutra en el intervalo de tiempo especificado (total, sub total, iva, fecha de emisión)
		</p>
		<a onClick="generar(event, 'fecha_desde%fecha_hasta' )" id="btn_submit" class="btn btn-primary"> Generar </a>
	</div>	
	<input type="hidden" name="action" id="action" value="enTiempo">

	
</div>