@extends('layouts.dashboard_layout')
@section('titulo', 'Control de metodos de egreso')

@section('contenedor')

<div class="container">
	
	<div class="row">
		<div class="col-sm-5">
			<h3 class="page-header">Manejo de metodos de egreso</h3>
		</div>
	</div>
		
	<div class="row">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<button class="btn btn-primary btn-forms" id="nuevo" formulario="nuevo" data-toggle="modal" data-target="#modal_forms">Crear nuevo metodo</button>
				</div>
			</div>
		</div>
		<br><br>

		<div class="col-sm-9">
		<input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
			
			<table class="table table-striped table-hover" id="dataTables-example">
				
				<thead>
					<tr>
						<th>Nombre del metodo</th>
						<th>Codigo del metodo</th>
						<th>Descripcion del metodo</th>
						<th>Opciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($metodos as $metodo)
						<tr>
							<td>{{ $metodo->descripcion_razon }}</td>
							<td>{{ $metodo->codigo_razon }}</td>
							<td>{{ $metodo->explicacion_razon }}</td>
							<td>
								<button class="btn btn-danger usuario-option" role="suprimir" metodo-id="{{ $metodo->id }}">
	                                <span class="glyphicon glyphicon-remove"></span>
	                            </button>
							</td>
						</tr>
					@endforeach
				</tbody>

			</table>

		</div>

	</div>

<div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Gestion de metodos de egresos <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="" method="post" class=""  id="cargar_info">
                    <div id="form-inputs">
                        
                    </div>
                </form>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
        <button type="button" class="btn btn-primary" id="modal-click">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- FIN DE LA VENTANA MODAL -->

</div>

</div>

<!-- INICIO DEL JAVASCRIPT -->
@endsection
@section('jquery')
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>
<script>
	$(document).ready(function(){
		$('#dataTables-example').DataTable({
            responsive: true
        });
        /**
        *	MECANISMO PARA ABRIR EL FORMULARIO 
        */
        $(".btn-forms").click(function(){
           
            var form = $(this).attr('formulario');
            var url = location.href+'/formulario/'+form;
           	 
            $.getJSON(url, '', function(response){
                if(!response.fail)
                {
                    $("#form-inputs").html(response.formulario);
                    $("#cargar_info").attr("util-form", form);
                }
            });
            $("#modal_forms").modal('open')
        });

        $("#modal-click").on('click', function(){
        	var datos = $("#cargar_info").serialize();
        	var url = location.href+'/salvarInformacion'
        	var success = function(response){
        		alert(response.mensaje);
     			if(! response.error)
     				location.reload();
        	};

        	$.post(url, datos, success);
        });

        $(".usuario-option").on('click', function(){
        	var url = location.href+'/salvarInformacion';
        	var parametros = { 
        		'_token' : $("#token").val(), 
        		'accion' : $(this).attr('role'),
        		'id' : $(this).attr('metodo-id'),
        	};

        	var success = function(response)
        	{
        		alert(response.mensaje);
        		if(! response.error)
        			location.reload();
        	}
        	if(confirm('¿Seguro que desea suprimir este registro?'))
        		$.post(url, parametros, success);

        });
	});
</script>

@endsection