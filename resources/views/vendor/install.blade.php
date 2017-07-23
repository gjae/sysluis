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
		
		<div class="row">
			<div class="col-sm-12" style="text-align: center;">
				<h3>¡Bienvenidos a la instalacion!</h3>
			</div>
			<div class="col-sm-12">
				<blockquote style="text-align: center;">
					En el siguiente formulario se solicitaran datos tales como las credenciales para poder acceder a la base de datos, el tipo de base de datos, el nombre de usuario etc. A demas sera necesario otros datos que seran de ayuda para configurar tu sistema.
				</blockquote>
			</div>
		</div>
		
		<form action="{{ url('instalar/procesar') }}" method="post" id="env">
			<div class="container">
			{{ csrf_field() }}
			<input type="hidden" name="accion" value="env">
			<input type="hidden" name="url_app" id="url_app" value="">
				<div class="row">
					
					<div class="col-sm-6">
						<label for="db_name">Nombre de la base de datos</label>
						<input type="text" required name="db_name" placeholder="Nombre de tu base de datos" class="form-control">
					</div>
					<div class="col-sm-6">
						<label for="db_driver">Tipo de base de datos</label>
						<select required name="db_driver" id="db_driver" class="form-control" onchange="db_driver_select(this.value)">
							<option value="">-----</option>
							<option value="pgsql">PostgreSQL</option>
							<option value="mysql">MySQL</option>
						</select>
					</div>

				</div>
				<div class="row">
					
					<div class="col-sm-3">
						<label for="host">Host de la base de datos</label>
						<input type="text" required value="127.0.0.1" name="db_host" class="form-control">
					</div>	
					<div class="col-sm-3">
						<label for="user">Usuario de la base de datos</label>
						<input type="text" required name="db_user" id="db_user" class="form-control" value="-----">
					</div>
					<div class="col-sm-3">
						<label for="db_password">Clave de la base de datos</label>
						<input type="password" required name="db_password" class="form-control" onkeyup="insert_password(event, this.value)" id="db_password">
						<div class="alert hidden" id="alert-len">Correcta</div>
					</div>
					<div class="col-sm-3">
						<label for="db_password2">Repite la clave</label>
						<input type="password" required name="db_password2" class="form-control" onkeyup="repeat_password(event, this.value)">
						<div class="alert hidden" id="alert-repeat"></div>
					</div>

				</div>
			</div>

			<div class="container">
				
				<div class="row">
					<div class="col-sm-12" style="text-align: center;">
						<h3>Configuracion de correo electronico</h3>
						<blockquote>
							<h4>¡Ya has llegado hasta aqui!</h4>
							Ahora te solicitaremos los datos del correo electronico para configurar cualquier tipo de actividad que te gustaria ejercer en el futuro, como notificarle a tu clientela ciertas novedades.
						</blockquote>
					</div>

				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-success">
							<strong>
								Estos datos pueden ser alterados luego, por ahora se recomienda completarlo con la informacion mas correcta.
							</strong>
						</div>
					</div>
					
					<div class="col-sm-3">
						<label for="mail_user">Correo electronico</label>
						<input required type="email" class="form-control" name="mail_user" id="mail_user">
					</div>
					<div class="col-sm-3">
						<label for="mail_password">Clave del correo</label>
						<input type="password" required name="mail_password" class="form-control"  id="mail_password" required>
					</div>
					<div class="col-sm-2">
						<label for="mail_host">Host del correo</label>
						<input type="text" readonly name="mail_host" value="smtp.gmail.com" class="form-control">
					</div>
					<div class="col-sm-2">
						<label for="mail_port">Puerto</label>
						<input type="number" name="mail_port" class="form-control" id="mail_port" readonly value="587">
					</div>
					<div class="col-sm-2">
						
						<label for="mail_encrypt">Encriptacion</label>
						<input type="text" readonly class="form-control" name="mail_encrypt" id="mail_encrypt" value="ssl">

					</div>

				</div>

				<div class="row" style="margin-top: 33px;">
					<div class="col-sm-8">
						<button class="btn btn-primary" id="guardar" onclick="event.preventDefault()">
							Guardar
						</button>
					</div>
				</div>

			</div>
		</form>

	</div>

</section>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>	
<script>

	$(document).ready(function(){
		$("#url_app").val('http://'+location.hostname);
		$("#guardar").on('click',function(){
			
			var datos = [
				'db_name', 'db_host', 'db_driver', 'db_user', 'db_password',
				'mail_user', 'mail_password', 
			];
			var campos_vacios = false;

			datos.forEach(function(dato, i){
				if($("#"+dato).val() == '' )
				{
					campos_vacios = false;
				}
			})
			if(campos_vacios){
				alert('Aun hay datos pendientes por completar');
				return false;
			}

			$("#env").submit();
		})

	})
	function db_driver_select(driver)
	{
		$("#db_user").val( (driver == 'mysql')? 'root' : 'postgres' );
	}

	function insert_password(event, valor)
	{
		if(valor!='')
		{
			var alerta = $("#alert-len");
			if(event.keyCode == 13)
				event.preventDefault()
			if(valor.length < 6)
			{
				
				if(alerta.hasClass('hidden'))
					alerta.removeClass('hidden');
				alerta.addClass('alert-danger');
				alerta.html('Esta clave es muy debil aun');
			}
			else
			{
				alerta.removeClass('alert-danger');
				alerta.addClass('alert-success');
				alerta.html('Luce bien');
			}
		}

	}

	function repeat_password(event, valor)
	{
		if(valor!='')
		{
			var pass1 = $("#db_password").val();
			var alerta = $("#alert-repeat");
			if(event.keyCode==13)
				event.preventDefault();

			if(valor == pass1)
			{
				if(alerta.hasClass('hidden'))
					alerta.removeClass('hidden');

				alerta.removeClass('alert-danger');
				alerta.addClass('alert-success');
				alerta.html('Luce bien')

			}
			else
			{
				if(alerta.hasClass('hidden'))
					alerta.removeClass('hidden');

				alerta.addClass('alert-danger');
				alerta.html('Las claves no coinciden')
			}
		}
	}

</script>
</body>
</html>