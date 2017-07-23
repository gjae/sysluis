@extends('layouts.web')

@section('titulo', 'Envia un pago')

@section('body')

<div class="container">
	


<div class="row">
	
	<div class="col-lg-8 col-md-12 form-services">
		<input type="hidden" name="monto" id="monto">
		<input type="hidden" id="codigo_solicitud_hhidden">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 push-md-3 col-md-4 col-lg-8 ">
						<label for="codigo_solicitud">Ingrese el codigo de su solicitud</label>
						<div class="input-group">
						

							<input type="text" name="codigo_solicitud" id="codigo_solicitud" class="form-control" placeholder="Codigo de la solicitud"> 
							<span class="input-group-btn">
							<button id="buscar" class="btn btn-success">Consultar</button>
							</span>
						</div>

					</div>
					<div class="col-sm-4">
						<label for="">Tipo de pago</label>
						<select name="modalidad_pago_id" id="modo_pago" class="form-control">
							<option value="--" selected>----</option>
							@foreach($modos as $modo)
								@if($modo->codigo_modalidad == 'ONL' || $modo->codigo_modalidad == 'TDC' )
									<option value="{{ $modo->codigo_modalidad }}">
										{{ $modo->nombre_modalidad }}
									</option>
								@endif
							@endforeach

						</select>
					</div>	
				</div>
				<div class="row">
					<div class="col-sm-8" id="formulario"></div>
				</div>
				<div class="row" style="margin-top: 12px;">
					<div class="col-sm-11" id="estatusbar">
					</div>
				</div>
			</div>	
		
	</div>

</div>


@endsection
@section('js')


<script src="{{ asset('js/servicios/solicitudTableComponent.js') }}"></script>>
<script>
var buscarCedula = (e, obj) =>{
	if(e.keyCode == 13){
		e.preventDefault()
		let uri = location.host;
		$.get(uri, function(e){
			console.log(e)
		})
	}
}
$(document).ready( () =>{
	const base_url = location.hostname+':'+location.port;

	const codigo_transaccion = $("#codigo_transaccion")
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
			
			$.get('consultar-estatus/'+codigo, function(response){
				if(! response.error){
					var cliente = response.cliente

					codigo_transaccion.prop('readonly', false);
					var alerta = ` 
						<div class="alert ${response.estatus.color_estatus}" id="alert" style="text-align: center;"> 
								<strong id="txtstatus">Este trabajo se encuentra en estaus: ${response.estatus.nombre_estatus}</strong>
						 </div>
						`
					$("#estatusbar").html(alerta)
					$("#estatusbar").append(table(response))

					var solicitud = response.solicitud.datos;
					$("#codigo_solicitud_hhidden").val(solicitud.codigo_solicitud)
					$("#monto").val(monto.precio)
					
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

	$("#modo_pago").on('change', ()=>{

		if( $("#modo_pago").val() == 'TDC' )
			$("#formulario").html(formPago())
	})

	var buscarCedula = (e, obj) =>{
		alert(2)
	}
} )


</script>
@endsection