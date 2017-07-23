<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>¡Bienvenido al sistema!</title>
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/install.css') }}">
</head>
<body>

<section id="inicio">
	
	<div class="container contenedor">
		<form action="{{ url('instalar/procesar') }}" method="post" id="env" enctype="multipart/form-data">
			<div class="container">
				{{ csrf_field() }}
				<input type="hidden" name="accion" value="empresa">

				<div class="row">
					<div class="col-sm-12" style="text-align: center;">
						<h3 class="page-header">¡Se ha instalado el sistema!</h3>
						<blockquote>
							Se ha logrado instalar el sistema, ahora solo resta agregar la informacion de tu negocio y un usuario para el sistema.
						</blockquote>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" id="nombre" class="form-control" required>
					</div>
					<div class="col-sm-4">
						<div class="row">
							<div class="col-sm-3">
								<label for="personalidad">Tipo</label>
								<select name="personalidad" required class="form-control" id="personalidad">
									<option value="">------</option>
									<option value="J">J</option>
									<option value="V">V</option>
									<option value="N">N</option>
									<option value="E">E</option>	
								</select>
							</div>
							<div class="col-sm-9">
								<label for="rif">RIF</label>
								<input type="text" name="rif" id="rif" required placeholder="12345678-0" class="form-control">
							</div>
						</div>
					</div>

					<div class="col-sm-3">
						<label for="logo">Logo de tu empresa</label>
						<input type="file" name="logo" id="logo" class="form-control">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">
						<label for="direccion">Direccion</label>
						<textarea name="direccion" id="" required class="form-control" cols="30" rows="10"></textarea>
					</div>
					<div class="col-sm-5">
						<label for="actividad">Actividad</label>
						<textarea name="actividad" id="" cols="30" class="form-control" required rows="10"></textarea>
					</div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-sm-9">
						<button class="btn btn-success">Es correcto</button>
					</div>
				</div>
			</div>
		</form>

	</div>

</section>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>	

</script>
</body>
</html>