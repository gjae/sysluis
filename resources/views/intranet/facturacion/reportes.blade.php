@extends('layouts.dashboard_layout')

@section('titulo', 'Reportes de facturas')

@section('css')

@endsection

@section('contenedor')


<div class="container" id="formulario_facturas">
	
	<div class="row">
		
		<div class="col-sm-7">
			
			<h1 class="page-header">
				Generación de reportes
			</h1>
			
			<form action="#" method="GET" id="reportes">
				
				<div class="container">
					<div class="row">
						<div class="col-sm-4">

							<label for="tipo_reporte">Tipo de reporte</label>
							<select name="tipo_reporte"  id="tipo_reporte" >
								<option value="null">------</option>
								<option value="enTiempo">Intervalo de fechas</option>
							</select>
						</div>
					</div>

					<div class="row" id="formulario">
						

					</div>
				</div>

			</form>

		</div>
	</div>

</dir>


@section('jquery')

<script>
	
	$(document).ready(function(){

		$('#tipo_reporte').on('change', function(event){
			var reporte = $(this)

			if(reporte.val()  !='null')
			{
				var respuesta = function(response){
					if(!response.error) $('#formulario').html(response.formulario)
					else $('#formulario').html('<h1 class="page-header"> Error: el servidor no responde </h1>');
				}
				$.get(location.href + '/formularios/' + reporte.val(), '', respuesta)
			}
			else $('#formulario').html('');
		});

	})

function generar(event)
{
	var datos = $('#reportes').serialize();
	var action = $('#action').val()
	var respuestAjax = function(response){
		alert(response)
	}

	window.open(location.href+'/'+action+'?'+datos, '_blank');
	//$.get( , datos, respuestAjax );
}
</script>

@endsection

@endsection