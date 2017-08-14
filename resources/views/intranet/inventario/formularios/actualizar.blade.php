<div class="container">
	<div class="row">
	
		<form action="{{ url('dashboard/inventario/Hardware/actualizar') }}" enctype="multipart/form-data" method="post" data-url="actualizar">

			<input type="hidden" name="hardware_id" value="{{ $hardware->id }}">
			{{ csrf_field() }}
			<div class="container">
				<div class="row">
					
					<div class="col-sm-5">
						<label for="nombre_hardware">Nombre del dispositivo</label>
						<input type="text" value="{{ $hardware->nombre_hardware }}" name="nombre_hardware" id="nombre_hardware" placeholder="Ej: Monitor" class="form-control">
					</div>

					<div class="col-sm-5">
						<label for="codigo_hardware">Codigo del dispositivo</label>
						<input type="text" value="{{ $hardware->codigo_hardware }}" name="codigo_hardware" id="codigo_hardware" class="form-control">
					</div>

				</div>
				<div class="row">
					
					<!--<div class="col-sm-5">
						<label for="stock">Foto del producto</label>
						<input type="file" readonly value="{{ $hardware->imagen }}" name="imagen">
					</div> -->

					<div class="col-sm-5">
						
						<label for="proveedor">Categoria del producto</label>
						<select name="categoria_id" id="categoria_id" class="form-control">
							<option value="0">-----------------</option>
							@foreach($categorias as $categoria)
								@if( $hardware->categoria->nombre_categoria == $categoria->nombre_categoria )
									<option value="{{ $categoria->id }}" selected>
										{{ $categoria->nombre_categoria }}
									</option>
								@else
									<option value="{{ $categoria->id }}" selected>
										{{ $categoria->nombre_categoria }}
									</option>
								@endif

							@endforeach
						</select>

					</div>
				</div>

				<div class="row">
					
					<div class="col-sm-2">
						<label for="precio">Precio</label>
						<input type="number" value="{{ $hardware->precio }}" name="precio" class="form-control">
					</div>

				</div>
			</div>		
			<div class="row">
				<div class="col-sm-7">
					<input type="submit" class="btn btn-primary" value="Guardar datos">
				</div>
			</div>
		</form>

	</div>
</div>