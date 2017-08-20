@extends('layouts.dashboard_layout')

@section('titulo', 'Mis asignaciones')

@section('contenedor')

<section id="asignaciones">
	
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<h3 class="page-header">Lista de trabajos pendientes</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-7">
			
			<table  class="table table-striped table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th> Código </th>
						<th> Estatus </th>
						<th> Fec. asignacion </th>
						<th> Opciones </th>
					</tr>
				</thead>
				<tbody>
					@foreach($asignaciones as $asignacion)
						<tr>
							<td>{{ $asignacion->solicitud->codigo_solicitud }}</td>
							<td>{{ $asignacion->solicitud->estatus->nombre_estatus }}</td>
							<td>
								{{ $asignacion->created_at->format('d - m- Y h:i:s A') }}
							</td>
							<td>
								<button class="btn btn-warning btn-form" role="detalles" id="{{ $asignacion->id }}" data-toggle="modal" data-target="#modal_forms">Detalles</button>
							</td>
						</tr>
					@endforeach
				</tbody>

			</table>

		</div>
	</div>
</div>

<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
<div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Datos de la asignación <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="" method="post" class=""  id="cargar_info">
                {{ csrf_field() }}
                    <div id="form-inputs">
                        
                    </div>
                </form>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
        <button type="button" class="btn btn-primary" id="modal-click">Guardar datos</button>
      </div>
    </div>
  </div>
</div>

</section>

@endsection
@section('jquery')

<script>
	
	$(document).ready(function(){
		$(".btn-form").on('click', function(){
			var url = location.href+'/detalles/'+$(this).attr('id');
			var success = function(response){
				if( !response.error)
				{
					$("#form-inputs").html(response.formulario);
				}
			};

			$.getJSON(url, '', success);
		});

		$('#modal-click').on('click', function(){
			var datos = $("#cargar_info").serialize();
			var url = location.href+'/guardarCambios';
			var success = function(response){
				if(! response.error)
				{
					alert(response.mensaje);
					location.reload();
				}
			};

			$.post(url, datos, success);
		});

	});


function agregar(e){
	console.log(e)
}
</script>

@endsection