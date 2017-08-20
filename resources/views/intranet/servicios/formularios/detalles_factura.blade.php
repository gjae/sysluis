<div class="container">
	{{ csrf_field() }}
	<input type="hidden" name="accion" id="accion" value="facturar">
	<input type="hidden" name="solicitud_id" id="solicitud_id" value="{{ (int) $solicitud->id }}">
	<input type="hidden" name="precio" id="precio" value="{{ $solicitud->precio }}">
	<input type="hidden" name="subtotal" id="subtotal" value="{{ $solicitud->precio - $solicitud->abono }}">
	<input type="hidden" name="iva" id="iva" value="{{ $solicitud->iva }}">
	<input type="hidden" name="total" id="total" value="{{ $solicitud->total }}">
	<input type="hidden" name="cliente_id" id="cliente_id" value="{{ $solicitud->cliente->id }}">
	<input type="hidden" name="empleado_id" id="empleado_id" value="{{ Auth::user()->empleado->id }}">
	<input type="hidden" name="tipo_servicio_id" id="tipo_servicio_id" value="4">

	<div class="row">
		<div class="col-sm-10">
			<h3 class="page-header">
				Ingrese monto
			</h3>
		</div>

		<div class="col-sm-4">
			<label for="dinero_recibido">Dinero recibido</label>
			<input type="number" name="dinero_recibido" id="dinero_recibido" class="form-control" onkeypress="calcularCambio(event, this.value)">
		</div>

		<div class="col-sm-3">
			<label for="cambio">Cambio</label>
			<input type="number" value="0" readonly name="cambio" id="cambio" class="form-control">
		</div>


		<div class="col-sm-2">
			<button class="btn btn-primary" id="generar" onclick="guardar(event)">Generar factura</button>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-10">
			<h3 class="page-header">
				Detalles de pago
			</h3>
		</div>
		<div class="col-sm-3">
			<label for="precio">Precio total (sin IVA)</label>
			<input type="text" readonly value="{{ number_format($solicitud->precio,2) }}" class="form-control">
		</div>
		<div class="col-sm-3">
			<label for="abono">Abono del cliente</label>
			<input type="text" readonly value="{{ number_format($solicitud->abono,2) }}" class="form-control">
		</div>
		<div class="col-sm-3">
			<label for="restantes">Total</label>
			<input type="text" readonly name="restantes" value="{{ number_format( ($solicitud->total) ,2) }}" class="form-control">
		</div>

	</div>
	<div class="row">
		<div class="col-sm-4">
			<label for="">Concepto</label>
			<input type="text" name="concepto" class="form-control">
		</div>

		<div class="col-sm-3">
			<label for="">Forma de pago</label>
			<select name="modalidad_pago_id" id="modalidad_pago_id" onChange="modalidad_pago(this.value)" class="form-control">
				<option value="">------</option>
				@foreach($modalidades as $modalidad)
					<option value="{{ $modalidad->id }}">
						{{ $modalidad->nombre_modalidad }}
					</option>
				@endforeach
			</select>
		</div>

		<div class="col-sm-3 hidden" id="nro_transaccion">
			<label for="">Nro. de transacción / cheque</label>
			<input type="text" name="codigo_pago" id="codigo_pago" class="form-control">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-10">
			<h3 class="page-header">
				Detalles de la solicitud
			</h3>
		</div>
		<div class="col-sm-4">
			<label for="cliente">Cliente</label>
			<input type="text" value="{{ $solicitud->cliente->persona->nombres.' '.$solicitud->cliente->persona->apellidos }}" readonly id="cliente" class="form-control">
		</div>
		<div class="col-sm-2">
			<label for="codigo">Código</label>
			<input type="text" value="{{ $solicitud->codigo_solicitud }}" readonly id="codigo" class="form-control">
		</div>

		<div class="col-sm-2">
			<label for="fecha">Fec. Solicitud</label>
			<input type="text" readonly id="fecha" value="{{ $solicitud->created_at->format('d-m-Y') }}" class="form-control">			

		</div>
		
		<div class="col-sm-8">
			<label for="detalles">Detalles y Observaciones</label>
			<textarea name="detalles" readonly id="" cols="30" rows="10" class="form-control">{{ $solicitud->detalles }}</textarea>
		</div>
	</div>

</div>