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
		<form action="{{ url('instalar/procesar') }}" method="post" id="env">
			<div class="container">
				{{ csrf_field() }}
				<input type="hidden" name="accion" value="putDatabase">

				<div class="row">
					<div class="col-sm-12" style="text-align: center;">
						<h3 class="page-container">¡Ya casi!</h3>
						<blockquote>
							Estas a un paso de terminar la instalacion, ahora verifica que estos datos sean correctos y has click en continuar, de no ser correctos solo ve hacia atras y acomodalo.
						</blockquote>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" style="text-align: center;">
						<h3 class="page-header">Datos de la base de datos</h3>
					</div>
					<div class="col-sm-5">
						<strong>Tipo de base de datos: {{ ($db_driver == 'mysql') ? 'MySQL' : 'PostgresSQL' }}  </strong>
						<br>
						<strong>
							Usuario: {{ $db_user }}
						</strong>
						<br>
						<strong>
							Clave: {{$db_password}}
						</strong>
						<br>
						<strong>
							Host: {{$db_host}}
						</strong>
						<br>
						<strong>
							Base de datos: {{$db_name}}
						</strong>
					</div>
				</div>
				<dv class="row">
					<div class="col-sm-12" style="text-align: center;">
						<h3 class="page-header">Configuracion de EMAIL</h3>
					</div>
					<div class="col-sm-5">
						<strong>
							Correo: {{$mail_user}}
						</strong>
						<br>
						<strong>
							Clave: {{$mail_password}}
						</strong>
					</div>
				</dv>
				<div class="row">
					<div class="col-sm-7">
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