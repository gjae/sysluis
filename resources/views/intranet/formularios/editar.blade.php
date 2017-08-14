{{ csrf_field() }}
<div class="contaier">

	<div class="row">
		
		<div class="col-sm-9">
			<h3 class="page-header">Formulario para editar al usuario {{ $user->usuario }} </h3>
		</div>

	</div>
	<div class="row">
		
		<div class="col-sm-3 col-md-3 col-lg-3">
			<label for="">Nombres</label>
			<input type="text" name="nombres" id="nombre" class="form-control" value="{{ $user->empleado->persona->nombres }}">
		</div>
		<div class="col-sm-3 col-md-3 col-lg-3">
			<label for="">Apellidos</label>
			<input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $user->empleado->persona->apellidos }}">
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<label for="">Cedula</label>
			<input type="text" name="cedula" id="cedula" class="form-control" value="{{ $user->empleado->persona->cedula }}">
		</div>
		<div class="col-sm-5 col-md-5 col-lg-5">
			<label for="">Telefono personal</label>
			<input type="text" name="telefono_personal" id="telefono_personal" class="form-control" value="{{ $user->empleado->persona->telefono_personal }}">
		</div>
		<div class="col-sm-5 col-md-5 col-lg-5">
			<label for="">Telefono habitacion</label>
			<input type="text" name="telefono_habitacion" id="telefono_habitacion" class="form-control" value="{{ $user->empleado->persona->telefono_habitacion }}">
		</div>
	</div>
	<div class="row">
		

		<div class="container">
			<div class="row">
				<div class="col-sm-10">
					<label for="">Correo</label>
					<input type="email" name="email" id="email" class="form-control" value="{{ $user->empleado->persona->email }}">
				</div>
				<div class="col-sm-10">
					<label for="">Direccion de residencia</label>
					<textarea name="direccion" id="" cols="30" rows="10" class="form-control">{{ $user->empleado->persona->direccion }}</textarea>
				</div>
			</div>
		</div>

	</div>

	<input type="hidden" id="accion" value="editar">
</div>