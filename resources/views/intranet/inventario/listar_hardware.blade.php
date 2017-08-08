@extends('layouts.dashboard_layout')

@section('titulo', 'Gestion de inventario - Hardware')

@section('css')
<!-- DataTables CSS -->
<link href="{{ asset('css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
<link href="{{ asset('css/dataTables.responsive.css')}}" rel="stylesheet">
@endsection


@section('contenedor')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Stock de mercancía a la fecha</h1>
                    <div class="panel panel-primary">
            <div class="panel-heading">
                Listado de equipos y mercancía disponible a {{ Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
                        <!-- /.panel-heading -->
            <div class="panel-body">
            	<div class="container">
            		<div class="row">
            			<div class="col-sm-12">
            				<button class="btn btn-primary btn-forms" formulario="insertar_hardware" data-toggle="modal" data-target="#modal_forms">
            					 <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Crear
            				</button>
            			</div>
            		</div>
            	</div>
            	<br>

				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
                        <tr>
                            <th>Nombre del equipo</th>
                            <th>Codigo</th>
                            <th>Precio </th>
                            <th>Stock</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($hardwares as $hardware)
                            @if($hardware->edo_reg == 1)
                                <tr class="odd gradeX user_field">
                                    <td>{{ $hardware->nombre_hardware }}</td>
                                    <td>{{ $hardware->codigo_hardware }}</td>
                                    <td>{{ number_format($hardware->precio, 2) }}</td>
                                    <td>{{ $hardware->stock->stock - \App\Hardware::hardwaresVendidosPorId($hardware->id)  }}</td>
                                    <td>
                                        <button class="btn btn-danger usuario-option delete" token="{{ csrf_token() }}" data-id="{{ $hardware->id }}" role="DELETE" >
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                        <button class="btn btn-success usuario-option" token="{{ csrf_token() }}" role="UPDATE">
                                            <span class="glyphicon glyphicon-pencil "></span>
                                        </button>
                                        <button class="btn btn-warning usuario-option" token="{{ csrf_token() }}" id="permisos" role="PERMISOS" >
                                            <span class="glyphicon glyphicon-wrench"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
				</table>

        	</div>

        </div>
         <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
<div class="modal fade" id="modal_hardware" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Gestion de usuarios <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <div id="formulario">

                </div>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar ventana</button>
        <button type="button" class="btn btn-primary" id="modal-click">Guardar datos</button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->



@endsection
@section('jquery')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src=" {{ asset('js/dataTables.bootstrap.min.js') }} "></script>
<script src="{{ asset('js/dataTables.responsive.js')  }}"></script>

<script src="{{ asset('js/hardware.js') }}"></script>
@endsection
