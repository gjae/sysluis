<input type="hidden" name="accion" value="actualizar">
<input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<label for="cliente">Cliente</label>
			<input type="text" class="form-control" readonly value="{{ $solicitud->cliente->persona->nombres.' '.$solicitud->cliente->persona->apellidos }}" name="cliente" id="cliente">
		</div>

		<div class="col-sm-4">
			<label for="codigo_solicitud">Codigo de la solicitud</label>
			<input type="text" readonly name="codigo_solicitud" id="codigo_solicitud" class="form-control" value="{{ $solicitud->codigo_solicitud }}">
		</div>
	</div>

	<div class="row">
		
		<div class="col-sm-4">
			<label for="fecha">Fecha de la solicitud</label>
			<input type="text" readonly value="{{ $solicitud->created_at->format('d-m-Y') }}" class="form-control">
		</div>

		<div class="col-sm-6">
			<label for="estatus_id">Estatus del trabajo</label>
			<select name="estatus_id" id="estatus_id" class="form-control">
				@foreach($estatus as $est)
					@if($est->id == $solicitud->estatus_id)
						<option value="{{ $est->id }}" selected="true">
							{{ $est->nombre_estatus }}
						</option>
					@else
						<option value="{{ $est->id }}">
							{{ $est->nombre_estatus }}
						</option>
					@endif
				@endforeach
			</select>
		</div>
		<div class="col-sm-3">
			<label for="total">Costo</label>
			<input type="text" readonly name="total" id="total" value="{{ number_format($solicitud->precio, 2 ) }}" class="form-control">
		</div>
		<div class="col-sm-3">
			<label for="abono">Abonado</label>
			<input type="text" readonly name="abono" value="{{ number_format($solicitud->abono,2) }}" class="form-control">
		</div>
		<div class="col-sm-3">
			<label for="restan">Pendientes</label>
			<input type="text" readonly value="{{ number_format( ($solicitud->precio - $solicitud->abono ), 2 ) }}" class="form-control">
		</div>

	</div>

	<div class="row">
		<div class="col-sm-8">
			<label for="detalles">Detalles</label>
			<textarea name="detalles" id="" cols="30" rows="10" class="form-control">{{ trim($solicitud->detalles) }}</textarea>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			<h3 class="page-header">
				Log de problemas resueltos
			</h3>
		</div>
	</div>

	<div id="row">
		<div class="col-sm-6 com-md-6 col-lg-6">
			<table class="table table-responsive">
				<thead>
					<td>Fecha y hora</td>
					<td>Titulo</td>
					<td>Detalles</td>
					<td>Opciones</td>
				</thead>
				<tbody>
					@if($asignacion->logProblemas)
						@foreach($asignacion->logProblemas as $key => $problema)
							<tr>
								<td>{{ $problema->created_at->format('d-m-Y h:i:s A') }}</td>
								<td>{{ $problema->titulo }}</td>
								<td style="overflow: hidden;">{{ $problema->detalles }}</td>
								<td>
									<button class="btn btn-danger eliminar-log" id="{{ $problema->id }}">Eliminar</button>
								</td>
							</tr>
						@endforeach
					@endif
					<tr>
						<td>
							<input type="text"  readonly name="created_at" value="{{ Carbon\Carbon::now() }}">
						</td>
						<td>
							<input type="text" placeholder="Titulo del error"  name="titulo_log">
						</td>
						<td>
							<input type="text" placeholder="Solucion al problema"  name="detalles_log">
						</td>
						<td>
							<button onClick="agregar(event)" class="btn btn-success add-log">Agregar</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>