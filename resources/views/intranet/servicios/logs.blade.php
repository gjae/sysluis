@extends('layouts.dashboard_layout')

@section('titulo', 'Historial de problemas resueltos')

@section('contenedor')


<div class="row">
	<h1 class="page-header">Logs de problemas resueltos</h1>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Lista de problemas resueltos por los usuarios
            </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="container">
            		<div class="row">
            			<div class="col-sm-12">
            				<button class="btn btn-primary btn-forms" formulario="crear_usuario" data-toggle="modal" data-target="#modal_forms">
            					 <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Crear
            				</button>
            			</div>
            		</div>
            	</div>
            	<br>
				
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
                        <tr>
                            <th>Fecha de agregacion</th>
                            <th>Titulo</th>
                            <th>Detalles</th>
                            <th>Codigo del caso</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($logs as $log)
                            <tr class="odd gradeX user_field">
                                <td> {{ $log->created_at->format('d-m-Y h:i:s A') }} </td>
                                <td> {{ $log->titulo }} </td>
                                <td> {{ $log->detalles }} </td>
                                <td> {{ $log->asignacion->solicitud->codigo_solicitud }} </td>
                                <td>
                                   {{ $log->user->empleado->persona->nombres }}
                                </td>
                            </tr> 
                        @endforeach
                    </tbody>
				</table>

        	</div>
		</div>
	</div>

@endsection
@section('jquery')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>

<script src="{{ asset('js/modulo_servicios.js') }}"></script>
@endsection