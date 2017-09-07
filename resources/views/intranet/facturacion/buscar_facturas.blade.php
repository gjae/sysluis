@extends('layouts.dashboard_layout')

@section('titulo', 'Consulta las facturas del sistema')


@section('contenedor')

<div class="container">
	<div class="row">
		
		<div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
			
			<label for="">Número de factura</label>
			<input type="text" id="factura_id" onkeyup="soloNumeros(event, this, 9)" placeholder="Ingresa el numero de factura y presione la tecla [ENTER]" name="factura_id" class="form-control">

			<blockquote>
				Ingrese el número de la factura a consultar y presione ENTER
			</blockquote>

		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
			<table class="table">
				<thead>
					<tr>
						<th>Factura</th>
						<th>Fecha de transacción</th>
						<th>Nro. de transacción</th>
						<th>Total de la compra</th>
						<th>Opciones</th>
					</tr>
				</thead>
				<tbody id="datos">
					
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
			<h3 class="page-header">Soporte de la transacción</h3>
			<img src=""  class="img-responsive" id="img-transaccion">
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
				alert("DEBE ESCRIBIR UN NúMERO DE FACTURA VÁLIDO")
				return false;
			}
			
			var url = location.href
			$.get(url+"/consultar?factura_id="+numero.val(), (resp) =>{
				if(resp.error)
					alert(resp.mensaje)
				else{
					var url = "http://"+location.host+"/consultar/factura-online?factura_id="+numero.val()

					var img = ""

					if( resp.deoposito != false)
					var img = "http://"+location.host+'/img/uploaders/'+resp.deposito.imagen_deposito
					
					var datos = `
						<tr>
							<td>${numero.val()}</td>
							<td>${resp.datos_factura.fecha}</td>
							<td>${resp.deposito.numero_transaccion}</td>
							<td>${resp.datos_factura.total}</td>
							<td><a href="${url}" target="_blank" class="btn btn-success">Imprimir</a></td>
						</tr>
					`

					$("#datos").html(datos)
					$("#img-transaccion").attr('src', img);
				}
				console.log(resp)
			});
		}
	})

})

</script>

@endsection
