@extends('layouts.dashboard_layout')

@section('titulo', 'Usuarios del sistema')

@section('css')
<!-- DataTables CSS -->
<link href="{{ asset('css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
<link href="{{ asset('css/dataTables.responsive.css')}}" rel="stylesheet">
@endsection

@section('contenedor')

<div class="row">
	<h1 class="page-header">Listado de solicitudes</h1>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Solicitudes al sistema
            </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="container">
            		<div class="row">
            			<div class="col-sm-12">
            				<button class="btn btn-primary btn_forms" data-url="formulario" data-solicitud="crear_solicitud" >
            					 <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Crear
            				</button> 
            			</div>
            		</div>
            	</div>
            	<br>
				
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
                        <tr>
                            <th>Codigo de solicitud</th>
                            <th>Fecha de solicitud</th>
                            <th>Cedula del cliente</th>
                            <th>Nombres del cliente</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($solicitudes as $solicitud)
                            <tr class="odd gradeX user_field">
                                <td> {{ $solicitud->codigo_solicitud }} </td>
                                <td> {{ $solicitud->created_at->toDateString() }} </td>
                                <td> {{ $solicitud->cliente->persona->cedula }} </td>
                                <td> {{ $solicitud->cliente->persona->nombres }} </td>
                                <td>
                                    <button class="btn btn-success btn_forms" data-solicitud="{{ $solicitud->id }}" data-url="cargar_empleados">Asignar trabajo</button>
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
        <h4 class="modal-title" id="myModalLabel">Gestion de servicios<span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="http://localhost:8000/solicitudes/servicios" method="post" class=""  id="cargar_info">
                    <div id="form-inputs">
                        
                    </div>
                </form>
            </div>
        </div>

      <div class="modal-footer" id="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
        <button type="button" class="btn btn-primary" id="modal-click">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- FIN DE LA VENTANA MODAL -->
</div>

@endsection

@section('jquery')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>

<script src="{{ asset('js/modulo_servicios.js') }}"></script>
@endsection