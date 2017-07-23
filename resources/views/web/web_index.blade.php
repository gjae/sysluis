@extends('layouts.web')

@section('titulo', 'Solicitudes de servicios')

@section('body')

<div class="container">
	


<div class="row">
	
	<div class="col-lg-8 col-md-12 form-services">
		
		<form  action="{{ url('solicitudes/servicios') }}" method="post">
			{{ csrf_field() }}
				<div class="container">
					
					<div class="row">
						<div class="col-sm-10">
							<h3>Datos personales</h3>
							<hr class="divider">
						</div>
						<div class="col-sm-11">
							<label for="cedula">Cedula</label>
							<input type="text" name="cedula" id="cedula" class="form-control">
						</div>
						<div class="col-sm-4">
							<label for="nombres">nombres</label>
							<input type="text" name="nombres" id="nombres" class="form-control">
						</div>
						<div class="col-sm-4">
							<label for="apellidos">apellidos</label>
							<input type="text" name="apellidos" id="apellidos" class="form-control">
						</div>

						<div class="col-sm-3">
							<label for="email">Correo electronico</label>
							<input type="email" name="email" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label for="telefono">Telefono personal</label>
							<input type="text" name="telefono_personal" class="form-control">
						</div>
						<div class="col-sm-12 col-md-5 col-lg-6">
							<label for="telefono">Telefono de contacto</label>
							<input type="text" name="telefono_habitacion" class="form-control">
						</div>
					</div>
	
					<div class="row">
						<div class="col-sm-10">
							<h3>Datos del servicio</h3>
							<hr class="divider">
						</div>
						<div class="col-sm-6">
							<label for="tipo_servicio">Tipo de servicio solicitado</label>
							<select name="tipo_id" id="" class="form-control">
								<option value="0">------------</option>
								@foreach($tipos as $tipo)
									<option value="{{ $tipo->id }}">{{ $tipo->denominacion }}</option>
								@endforeach
							</select>
						</div>

						<div class="col-sm-5">
							<label for="tipo_servicio">Categoria del servicio</label>
							<select name="categoria_id" id="" class="form-control">
								<option value="0">------------</option>
								@foreach($categorias as $categoria)
									<option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-11">
							<label for="direccion">Dirección</label>
							<textarea name="direccion" id="direccion" class="form-control" cols="30" rows="10"></textarea>
						</div>
						<div class="col-sm-11">
							<label for="direccion">Explique aquí brevemente su problema</label>
							<textarea name="detalles" id="detalles" class="form-control" cols="30" rows="10"></textarea>
						</div>
					</div>
				</div>
				<br>
				<div class="row" style="margin-top: 12px; margin-left: 17px; margin-bottom: 17px;">
					<button type="submit" class="btn btn-primary btn-lg">Guardar</button>
				</div>

			
			
		</form>
		
	</div>

</div>

</div>

@endsection