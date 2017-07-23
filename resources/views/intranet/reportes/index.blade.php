@extends('layouts.dashboard_layout')

@section('titulo', ' Sistema de generacion de reportes ')

@section('contenedor')


<div class="row">

<div class="container">

	<div class="row">

		<div class="col-sm-4">
			<label for="">Cedula o rif del comprador</label>
			<form id="comprador">

				<div class="input-group">
					<input type="text" name="cedula" id="cedula" class="form-control">
					<span class="input-group-btn">
						<button class="btn btn-success" id="buscar">Buscar</button>
					</span>

				</div>

			</form>

		</div>

	</div>

	<div class="row">
		<div class="col-sm-8">
			<table class="table table-striped">

				<thead>
					<tr>
						<th>
							Nro. Factura
						</th>
						<th>
							Fecha
						</th>
						<th>
							Sub-total
						</th>
						<th>
							IVA
						</th>
						<th>
							Total
						</th>
						<th>
							Acciones
						</th>
					</tr>
				</thead>

				<tbody id="tabla_info"></tbody>
			</table>
		</div>
	</div>

</div>

</div>

@endsection
@section('jquery')

<script>

$(document).ready(function(){

	$("#buscar").click(function(event){
		event.preventDefault()
		var cedula = $("#cedula");
		if(cedula.val() == ''){
			alert("DEBE INGRESAR UNA CEDULA O RIF");
			return false;
		}

		/**
		 * FUNCION SUCCESS SE EJECUTA CUANDO SE HA COMPLETADO SATISFACTORIAMENTE
		 * LA PETICION AJAX AL SERVIDOR, RECIVE COMO ARGUMENTO
		 * LA RESPUESTA DEL SERVIDOR, RECORRE EL ARRAY
		 * DE FACTURAS PARA CREAR CADA FILA EN LA TABLA
		 */

		var success = function(respuesta){
			if(!respuesta.error)
			{
				var len = respuesta.facturas.length;
				var tr = '';
				for(var i = 0; i< len; i++)
				{
					tr+= "<tr><td>"+respuesta.facturas[i].id+"</td>";
					tr+= "<td>"+respuesta.facturas[i].created_at+"</td><td>"+respuesta.facturas[i].subtotal+"</td><td>"+respuesta.facturas[i].iva+"</td><td>"+respuesta.facturas[i].total+"</td>";

					ref = ( respuesta.facturas[i].tipo_servicio_id == 4 )? location.host+'/index.php/dashboard/servicios/Facturar/factura/'+respuesta.facturas[i].id : location.host+'/dashboard/facturacion/Facturacion/consultarFactura/'+respuesta.facturas[i].id;
					tr+="<td><a  accion='imprimir' href='"+ref+"' class='btn btn-primary'>Imprimir</a>"
					//tr+="<td><button accion='anular' class='btn btn-warning' numero='"+respuesta.facturas[i].id+"'>Anular</button>"

					tr+="</tr>";
				}
				$("#tabla_info").html(tr);
			}
			else
				alert(respuesta.mensaje)
		}
		var url = location.href;


		$.getJSON(url+'/consultar/'+cedula.val(), '', success);
	})

})

</script>

@endsection
