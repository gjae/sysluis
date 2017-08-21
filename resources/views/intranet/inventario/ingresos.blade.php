@extends('layouts.dashboard_layout')

@section('contenedor')

<div class="container">
	<h3 class="page-header">Formulario de ingreso / reabastecimiento de mercancia</h3>

	<section id="ingresos">
		
		<div class="row">
			<div class="col-sm-7">

				<form action="#" id="ingreso">
					{{ csrf_field() }}
					<input type="hidden" name="hardware_id" id="hardware_id">
					<input type="hidden" name="total" value="12" id="total">
					<div class="container">
						<div class="row">
							
							<div class="col-sm-4">
								<label for="hardware_codigo">Codigo del producto</label>
								<input type="text" onKeyUp="textoYNumero(event, this, 7)"   name="hardware_codigo" id="hardware_codigo" placeholder="A32B55" class="form-control" onkeypress="buscarProducto(event, this.value)">
							</div>
							<div class="col-sm-4">
								<label for="nombre_hardware">Nombre del producto</label>
								<input type="text" readonly name="nombre_hardware" id="nombre_hardware"  placeholder="Nombre del producto" class="form-control">
							</div>
						</div>

						<div class="row">
							
							<div class="col-sm-4">
								<label for="numero_factura">Numero de la factura de compra</label>
								<input type="text" onKeyUp="soloNumeros(event, this, 15)" name="numero_factura" class="form-control" id="numero_factura">
							</div>

							<div class="col-sm-4">
								<label for="cantidad">Cantidad adquirida</label>
								<input type="number" onKeyUp="soloNumeros(event, this, 4)" name="cantidad" class="form-control" id="cantidad">
							</div>

						</div>

						<div class="row">
							
							<div class="col-sm-2">
								<label for="iva">Porcentaje de IVA</label>
								<input type="number" onkeyup="validarPrecio(event, this)" required name="iva" id="iva" class="form-control">
							</div>	
							<div class="col-sm-3">
								<label for="precio_unitario">Precio unitario</label>
								<input type="text" name="precio_unitario" onkeyup="validarPrecio(event, this)" id="precio_unitario" class="form-control">
							</div>

						</div>
						<br><br>
						<div class="row">
							<div class="col-sm-12">
								<a href="" class="btn btn-primary" onclick="enviar(event)">Guardar</a>
							</div>
						</div>
					</div>

				</form>
				
			</div>
		</div>

	</section>
</div>
@endsection
@section('jquery')

<script>
	
	function buscarProducto(event, codigo){

		if( event.keyCode == 13 ){
			var url = location.href;
			event.preventDefault();
			var success = function(response){
				if( !response.error ){
					$("#hardware_id").val(response.producto.id);
					$("#nombre_hardware").val(response.producto.nombre_hardware);
				}
				else alert(response.mensaje)
			}

			$.get(url+'/buscar?_codigo='+codigo, success);

		}
	}

	function enviar(event)
	{
		event.preventDefault();
		var datos = [
			'hardware_id', 'hardware_codigo', 'nombre_hardware', 'numero_factura', 
			'cantidad', 'iva', 'precio_unitario'
		];
		var bandera = true;
		datos.forEach(function(dato, index){
			
			if(bandera)
			{
				if( $("#"+dato).val() == '' ){
					alert('Aun tienes cosas pendientes por llenar');
					bandera = false;
					return bandera;
				}
			}
		});

		var cantidad = parseFloat($("#cantidad").val());

		var sbtotal = cantidad * parseFloat( $("#precio_unitario").val() );

		$("#total").val( sbtotal + ( sbtotal*parseFloat( $("#iva").val() ) )/100 );
		var success = function(response){
			if( !response.error){
				alert(response.mensaje)
				datos.forEach(function(dato, index){
					$("#"+dato).val('');
				});
				
			}
			else alert(response.mensaje);
		}

		data = $("#ingreso").serialize();

		$.post(location.href+'/guardar', data ,success);
	}

</script>

@endsection