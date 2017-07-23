@extends('layouts.web')

@section('titulo', 'Solicitudes de servicios')

@section('body')

<div class="container">
	


<div class="row">
	
	<div class="col-lg-8 col-md-12 form-services">
		
		<div class="container">
			
			<div class="row">
				<div class="col-sm-11">
					<h3>Consulta el estado de tu solicitud</h3>
					<hr class="divider"> 	
				</div>
				<div class="col-sm-8">
				<label for="codigo_solicitud">Ingresa tu codigo</label>
					<div class="input-group">
					

						<input type="text" name="codigo_solicitud" id="codigo_solicitud" class="form-control" placeholder="Codigo de la solicitud"> 
						<span class="input-group-btn">
						<button id="buscar" class="btn btn-success">Consultar</button>
						</span>
					</div>
				</div>
			</div>
			
			<div class="row" style="margin-top: 12px;">
				
				<div class="col-sm-11" id="estatusbar">
				</div>

			</div>
		</div>
		
	</div>

</div>

</div>

@endsection
@section('js')

<script src="{{ asset('js/servicios/solicitudTableComponent.js') }}"></script>
<script>

$(document).ready(function(){

	preloader = () => {
		return `
			<div class="container">
				<div class="row" style="text-align: center;">
					<div class="col-sm-4 col-sm-push-5" >
			 			<div class="loader"></div> 
			 		</div>
			 	</div>
			</div>
		`
	}
	/**
	 * ESTA CALLBACK SE ENCARGA DE BUSCAR LA SOLICITUD, ENVIA UNA PETICION
	 * AJAX AL SERVIDOR Y MUESTRA LOS DATOS EN LA VISTA
	 */
	var buscar = () =>{
		var url = location.href
		var codigo = $("#codigo_solicitud").val();
		$("#estatusbar").html(preloader());
		$.get(url+'/'+codigo, function(response){
			if(! response.error){
				var cliente = response.cliente

				console.log( table(response) )

				var alerta = ` 
					<div class="alert ${response.estatus.color_estatus}" id="alert" style="text-align: center;"> 
							<strong id="txtstatus">Este trabajo se encuentra en estaus: ${response.estatus.nombre_estatus}</strong>
					 </div>
					`
				$("#estatusbar").html(alerta)
				$("#estatusbar").append(table(response))
				
			}
			else{
				$("#estatusbar").html('')
				alert(response.mensaje)
			}
		})
	};

	$("#buscar").click(function(){
		buscar()
	})

	$("#codigo_solicitud").on('keypress', (e)=>{
		if(e.keyCode == 13){
			buscar()
		}
	})

})	

</script>

@endsection