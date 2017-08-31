<div class="container">
	<div class="row">
		
		<form action="{{ url('dashboard/inventario/Hardware/guardar') }}" enctype="multipart/form-data" method="post" data-url="guardar" onsubmit="cargarDatos(event, this)">
			{{ csrf_field() }}
			<div class="container">
				<div class="row">
					
					<div class="col-sm-5">
						<label for="nombre_hardware">Nombre del dispositivo</label>
						<input type="text" onKeyUp="textoYNumero(event, this, 40)" onKeyDown="textoYNumero(event, this, 40)" name="nombre_hardware" id="nombre_hardware" placeholder="Ej: Monitor" class="form-control">
					</div>

					<div class="col-sm-5">
						<label for="codigo_hardware">Codigo del dispositivo</label>
						<input type="text" onKeyUp="textoYNumero(event, this, 7)" onKeyDown="textoYNumero(event, this, 7)" name="codigo_hardware" id="codigo_hardware" class="form-control">
					</div>

				</div>
				<div class="row">
					
					<div class="col-sm-5">
						<label for="stock">Foto del producto</label>
						<input type="file" name="imagen">
					</div>

					<div class="col-sm-5">
						
						<label for="proveedor">Categoría del producto</label>
						<select name="categoria_id" id="categoria_id" class="form-control">
							<option value="">-----------------</option>
							@foreach($categorias as $categoria)
								<option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
							@endforeach
						</select>

					</div>
				</div>

				<div class="row">
					
					<div class="col-sm-2">
						<label for="precio">Precio</label>
						<input type="number" name="precio" onkeyup="validarPrecio(event, this)" class="form-control">
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