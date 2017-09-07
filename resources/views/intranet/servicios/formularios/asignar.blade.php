<div class="container">
	{{ csrf_field() }}
	<input type="hidden" id="accion"  name="accion" value="asignar">
	<input type="hidden" name="solicitud_id" value ="{{ $solicitud_id }}">
	<input type="hidden" id="iva" value="{{ env('IVA') }}">
	<input type="hidden" id="iva_servicio" name="iva" value="0">
	<div class="row">
		<div class="col-sm-8">
			<label for="empleados">Lista de Empleados Activos</label>
			<select name="empleado_id" id="empleado_id" class="form-control">
				@foreach($empleados as $empleado)
					
					<option value="{{ $empleado->id }}"> {{ $empleado->persona->nombres.' '.$empleado->persona->apellidos }} </option>

				@endforeach
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3">
			<label for="total">Total del trabajo (en Bs)</label>
			<input type="number"  onkeyup="validarPrecio(event, this)" name="precio" id="precio" value="0" class="form-control" onkeypress="calcularTotal(event)">
		</div>
		<div class="col-sm-3">
			<label for="abono">Cantidad abonada (en Bs)</label>
			<input type="number" name="abono" onkeyup="validarPrecio(event, this)" value="0" id="abono" class="form-control" onkeypress="calcularTotal(event)">
		</div>
		<div class="col-sm-3">
			<label for="iva_servicio">Total (con IVA)</label>
			<input type="number" onkeyup="validarPrecio(event, this)" name="total" id="total" class="form-control">
		</div>
	</div>

</div>