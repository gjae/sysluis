@extends('layouts.dashboard_layout')

@section('titulo', 'Gestion de facturación')

@section('css')

<link rel="stylesheet" href="{{ asset('css/facturacion.css') }}">

@endsection

@section('contenedor')

<div class="container" id="formulario_facturas">
	<div class="row">
		<div class="col-sm-8 col-md-8">	
			<h1 class="page-header">Facturación</h1>

			<form  method="post" id="facturacion" action="{{ url('dashboard/facturacion/factura') }}">
				{{ csrf_field() }}
				<input type="hidden" id="num-productos" num-productos="0">

				<input type="hidden" name="cliente_id" id="cliente_id">
				<div class="row">
					<div class="col-sm-5 ">
						<label for="cedula">Cedula</label>
						<input type="text" name="cedula" onChange="limpiarDatos(event)" id="cedula" onKeypress="buscarDatos(event, this.value)" class="form-control col-sm-3 ced-factura">
					</div>
					<div class="col-sm-5 pull-right">
						<label for="cedula">Nombres</label>
						<input type="text" name="nombre" disabled id="nombre" class="form-control col-sm-3 ced-factura">
					</div>
				</div>
				<!--./ DATOS DELCLIENTE -->

				<div class="row">
					
					<input type="hidden" id="persona_id" name="persona_id">
					<h4 class="page-header">Datos de la factura</h4>
					<button type="submit"  onClick="facturar(event)" class="btn btn-primary">Factura</button>
					<div class="col-sm-4">
						<label for="codigo">Codigo del producto o servicio</label>
						<input type="text" id="codigo_hardware" onKeypress="codigo(event, this.value)" name="codigo_hardware" class="form-control">
					</div>
					<div class="col-sm-3">
						<label for="codigo">Total (Con IVA incluido)</label>
						<input type="text" id="total" readonly="readonly" value="0" name="total" disabled class="form-control">
					</div>
					<div class="col-sm-3">
						<label for="">Seleccione una forma de pago</label>
						<select name="modalidad_pago_id" id="modalidad_pago_id" class="form-control">
							<option value="">----</option>
							@foreach($formas_pagos as $forma)
								<option value="{{ $forma->id }}">{{ $forma->nombre_modalidad }}</option>
							@endforeach
						</select>
					</div>
					<br>
					<br>
					<h4 class="page-header">Productos</h4>
					<div class="col-sm-10">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Cantidad</th>
									<th>Producto</th>
									<th>Precio unitario (SIN IVA)</th>
								</tr>
							</thead>
							<!-- LISTA DE LS PRODUCTOS -->
							<tbody id="productos_lista">
							</tbody>

							<!-- FIN DEL HTML DE LA LISTA DE PRODUCTOS -->
						</table>
					</div>
				</div>

			</form>
		</div>
		<!-- ./Fin del div col-sm del formulario -->
	</div>

<!-- INICIO DEL MODAL PARA LOS DATOS DEL CLIENTE -->
<!-- INICIO DE LA VENTANA MODAL DE LOS FORMULARIOS -->
<div class="modal fade" id="modal_forms" tabindex="-1" role="dialog" aria-labelledby="modal_formsLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registro de clientes <span id="verificando"></span> </h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <form action="" method="post" class=""  id="cargar_info">
                    {{ csrf_field() }}
                    <div class="container">
                    	<div class="row">
                    		<div class="col-sm-3">
                    			<label for="nombres">Nombre(s) de la persona</label>
                    			<input type="text" name="nombres" id="nombres" class="form-control">
                    		</div>
                    		<div class="col-sm-4">
                    			<label for="apellidos">Apellido(s) de la persona</label>
                    			<input type="text" name="apellidos" id="apellidos" class="form-control">
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-sm-7">
                    			<label for="email">Correo de la persona</label>
                    			<input type="email" name="email" id="email" class="form-control">
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-sm-3">
                    			<label for="telefono_personal">Telefono personal</label>
                    			<input type="text" name="telefono_personal" id="telefono_personal" class="form-control">
                    		</div>
                    		<div class="col-sm-4">
                    			<label for="telefono_habitacion">Telefono de habitación</label>
                    			<input type="text" name="telefono_habitacion" id="telefono_habitacion" class="form-control">
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-sm-7">
                    			<label for="direccion">Dirección fisica de la persona</label>
                    			<textarea name="direccion" id="direccion" class="form-control" cols="30" rows="10"></textarea>
                    		</div>
                    	</div>
			
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
<!-- FIN DEL MODAL -->

@section('jquery')
<script src="{{ asset('js/modulo_factura.js') }}"></script>
@endsection
</div>

@endsection