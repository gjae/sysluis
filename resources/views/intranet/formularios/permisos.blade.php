<div class="container">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-sm-7">
			<h2 class="page-header">Modulo</h2>
			<select name="modulo_id" id="modulo" class="form-control" onChange="permiso_modulo(this.value)">
				@foreach($modulos as $modulo)
					<option value=" {{ $modulo->id }} "> {{ $modulo->nombre_modulo }} </option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-7">
			<h2 class="page-header">Niveles de permisos en el modulo</h2>
			@foreach($permisos as $permiso)
				
				<input type="checkbox" class=""  name="permiso[]" value="{{ $permiso->id  }}" id="{{ $permiso->nombre_permiso }}"> {{ $permiso->nombre_permiso }}
				
			@endforeach
			<div id="verificando_permisos"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7">
			<h4 class="page-header">Tipo de acción</h4>
			
			<input type="radio" name="opcion" value="quitar"> Revocar Permisos
			<input type="radio" name="opcion" value="asignar"> Asignar Permisos
			
		</div>
	</div>

	<input type="hidden" id="accion" value="asignar_permisos">
</div>