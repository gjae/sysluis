{{ csrf_field() }}
<div class="container">

	<div class="row">
		<div class="col-sm-7 pull-col-md-3">
			<h4 class="page-header">Datos de la persona</h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 push-col-md-2">
			<label for="nombres">Nombre(s) del usuario</label>
			<input type="text" id="nombres" onKeyUp="soloTexto(event, this)" class="form-control" name="nombres">
		</div>
		<div class="col-sm-4 push-col-md-2">
			<label for="nombres">Apellido(s) del usuario</label>
			<input type="text" id="apellidos" onKeyUp="soloTexto(event, this)"  class="form-control" name="apellidos">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<label for="correo">Teléfono personal</label>
			<input type="text" id="telefono_personal" onKeyUp="soloNumeros(event, this, 15)" class="form-control" name="telefono_personal">
		</div>

		<div class="col-sm-3">
			<label for="correo">Teléfono de habitación</label>
			<input type="text" id="telefono_habitacion" onKeyUp="soloNumeros(event, this, 15)" class="form-control" name="telefono_habitacion">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7">
			<label for="direccion">Dirección de la persona</label>
			<textarea name="direccion" id="direccion" cols="77" rows="10"></textarea>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-7">
				<h4 class="page-header">Datos de usuario</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" class="form-control" id="usuario">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<label for="password">Clave del usuario</label>
				<input type="password" onKeyUp="longitudClave(event, this)"  class="form-control" id="password" name="password">
			</div>
			<div class="col-sm-3">
				<label for="password-repeat">Repita la clave</label>
				<input type="password"  onKeyUp="longitudClave(event, this)" class="form-control" id="password-repeat" name="password2">
			</div>
		</div>
	</div>
	<input type="hidden" id="accion" value="crear">
</div>