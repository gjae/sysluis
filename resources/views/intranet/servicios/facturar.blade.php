@extends('layouts.dashboard_layout')
@section('titulo', 'Facturacion de servicios')

@section('contenedor')

<section id="body">
	
<div class="row">
	<div class="col-sm-8">
		<h3 class="page-header">Facturar servicio</h3>
		<p>
			En esta tabla solo apareceran aquellas solicitudes con un estado de "LISTO"
			o "TERMINADO"
		</p>
	</div>
</div>

<div class="row">
	
	<div class="col-sm-9">
		<table class="table table-striped table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>Código</th>
					<th>Fec. solicitud</th>
					<th>Cliente</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($solicitudes as $indice => $solicitud)
					<tr>
						<td> {{ $solicitud->codigo_solicitud }} </td>
						<td> {{ $solicitud->created_at->format('m-d-Y') }} </td>
						<td> {{ $solicitud->cliente->persona->nombres. ' '.$solicitud->cliente->persona->apellidos }} </td>
						<td>
							<button class="btn btn-success usuario-option" 
									role="detalles"
									solicitud-id="{{ $solicitud->id }}" 
									data-toggle="modal" 
									data-target="#modal_forms"
							>
									Procesar
							</button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</div>

<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
<div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalles del servicio <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="" method="post" class=""  id="cargar_info">
                    <div class="row" id="form-inputs">
                        
                    </div>
                </form>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
      </div>
    </div>
  </div>
</div>

<!-- FIN DE LA VENTANA MODAL -->

</div>

</section>

@endsection
@section('jquery')
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>

<script>
	
	$(document).ready(function()
	{
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $(".usuario-option").on('click', function(){
        	var url = location.href+'/accion/'+$(this).attr('role')+'?_id='+$(this).attr('solicitud-id');

        	var success = function(response){
        		if(! response.error)
        			$("#form-inputs").html(response.formulario);
        		else
        			alert(response.mensaje);
        	}

        	$.getJSON(url, '', success);

        });

        $("#generar").click(function(){
        	$(this).preventDefault();
        	var data = $("#cargar_info").serialize();
        	alert(data);
        });
	});

	function calcularCambio(event, recibido)
	{
		if(event.keyCode == 13)
		{
			event.preventDefault()
			var total = parseFloat( $("#total").val() );
			var recibido = parseFloat(recibido);

			console.log( recibido > total )
			
			$("#cambio").val( parseFloat(recibido) - total );
			if ( recibido < total )
				alert("EL DINERO RECIBIDO ES MENOR AL TOTAL, SE REGISTRARA UNA PERDIDA")

		}
	}

	function guardar(event)
	{
        event.preventDefault();
        if( $("#dinero_recibido").val()!='' )
        { 
        	var datos = [
        		'dinero_recibido', 'modalidad_pago_id'
        	];
        	var url = location.href+'/accion';
        	var data = $("#cargar_info").serialize();
        	var bandera = true;
        	var success = function(response){
        		alert(response.mensaje)
        		if(! response.error)
        		{
        			window.open(location.href+'/factura/'+response.id, '_popup')
        		}
        	}

        	$.post(url, data, success);
        }
	}

	function modalidad_pago(opcion){
		if( opcion != 1 ){
			if( $("#nro_transaccion").hasClass('hidden') )
				$("#nro_transaccion").removeClass('hidden')
		}
		else if( opcion==1 && !$("#nro_transaccion").hasClass('hidden'))
		{
			$("#codigo_pago").val("")
			$("#nro_transaccion").addClass('hidden')
		}
	}

</script>

@endsection