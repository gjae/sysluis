@extends('layouts.dashboard_layout')

@section('titulo', 'Categorias')

@section('contenedor')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Categoría de productos</h1>
                    <div class="panel panel-primary">
            <div class="panel-heading">
                Listado de las categorías disponibles
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
                            <th>Denominacón de la categoria</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($categorias as $categoria)
                            @if( $categoria->edo_reg == 1)
                                <tr class="odd gradeX user_field">
                                    <td>{{ $categoria->nombre_categoria }}</td>
                                    <td>
                                        <button class="btn btn-danger usuario-option delete" token="{{ csrf_token() }}" data-id="{{ $categoria->id }}" role="DELETE" >
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                        <button class="btn btn-success usuario-option edit" token="{{ csrf_token() }}" data-id="{{ $categoria->id }}" role="UPDATE">
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
        <h4 class="modal-title" id="myModalLabel">Creación de categorias </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <div id="formulario">

                	<form action="" method="post" id="insertar_datos" data-url="guardar">
                		<div class="col-sm-10">
                			<label for="nombre_catergoria">Nombre de la nueva categoria</label>
                			<input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control">
                			 {{ csrf_field() }}
                		</div>
                	</form>

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
