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
				<input type="hidden" name="accion" value="usuario">
				<div class="row">
					<div class="col-sm-12" style="text-align: center;">
						<h3 class="page-header">¡Un ultimo paso!</h3>
						<blockquote>
							¡Excelente!, ya casi podras usar la plataforma, solo necesitas completar este ultimo formulario para crear el usuario administrador y comienza a disfrutar el servicio.
						</blockquote>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<label for="username">Nombre de usuario</label>
						<input type="text" name="usuario" class="form-control" required placeholder="Agrega un nombre de usuario que recuerdes">
					</div>
					<div class="col-sm-6">
						<label for="password">Clave</label>
						<input type="password" name="password" class="form-control" required>
					</div>
				</div>
				<br><br>
				<div class="row">
					<div class="col-sm-5">
						<button class="btn btn-success">Aceptar</button>
					</div>
				</div>
				<br><br>
			</div>
		</form>

	</div>

</section>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>	

</script>
</body>
</html>