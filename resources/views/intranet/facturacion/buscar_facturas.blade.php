@extends('layouts.dashboard_layout')

@section('titulo', 'Consulta las facturas del sistema')


@section('contenedor')

<div class="container">
	<div class="row">
		
		<div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
			
			<label for="">Numero de factura</label>
			<input type="text" id="factura_id" onkeyup="soloNumeros(event, this, 9)" placeholder="Ingresa el numero de factura y presione la tecla [ENTER]" name="factura_id" class="form-control">
			<blockquote>
				Ingrese el numero de la factura a consultar y presione enter
			</blockquote>

		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
			<table class="table">
				<thead>
					<tr>
						<th>Factura</th>
						<th>Fecha de transaccion</th>
						<th>Nro. de transaccion</th>
						<th>Total de la compra</th>
						<th>Opciones</th>
					</tr>
				</thead>
				<tbody id="datos">
					
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection
@section('jquery')

<script>
	
$(document).ready( ()=>{

	$("#factura_id").on('keypress', (event) =>{
		if(event.keyCode == 13){
			var numero = $("#factura_id");
			if(numero.val() == "")
			{
				alert("DEBE ESCRIBIR UN NUMERO DE FACTURA VALIDO")
				return false;
			}
			
			var url = location.href
			$.get(url+"/consultar?factura_id="+numero.val(), (resp) =>{
				if(resp.error)
					alert(resp.mensaje)
				else{
					var datos = `
						<tr>
							<td>Cliente</td>
							<td>${numero.val()}</td>
							<td>${resp.datos_factura.fecha}</td>
							<td>${resp.deposito.numero_transaccion}</td>
							<td>${resp.datos_factura.total}</td>
							<td><
						</tr>
					`

					$("#datos").html(datos)
				}
				console.log(resp)
			});
		}
	})

})

</script>

@endsection
