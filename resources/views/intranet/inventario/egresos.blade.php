@extends('layouts.dashboard_layout')

@section('titulo', 'Egresos de mercancias')

@section('contenedor')

<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<h3 class="page-header">
				Egreso de mercancía
			</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<p style="font-family: 'Helvetica';">
				Este proceso puede demorar un poco ya que consiste
				en sacar productos del stock y recalcular las cantidades existentes.
			</p>
		</div>
	</div>

	<section id="formulario">
		
		<form action="#" method="POST" id="egreso">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-8">
					<label for="razon">Motivo del egreso</label>
					<select name="razon_salida_id" id="razon_salida_id" class="form-control">
						<option value="">------------------</option>
						@foreach($razones as $razon)
							<option value="{{ $razon->id }}"> 
								{{ $razon->descripcion_razon.' ('.$razon->explicacion_razon.')' }} 
							</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<input type="hidden" id="stock_id" name="stock_id">
				<div class="col-sm-3">
					<label for="producto">Código del producto</label>
					<input type="text" class="form-control" name="codigo_hardware" id="codigo_hardware" onkeypress="buscarProducto(event, this.value)">
				</div>
				<div class="col-sm-3">
					<label for="nombre_hardware">Nombre del producto</label>
					<input type="text" name="nombre_hardware" id="nombre_hardware" readonly class="form-control">
				</div>

				<div class="col-sm-3">
					<label for="cantidad">Cantidad de unidades</label>
					<input type="number" id="cantidad" name="cantidad" class="form-control" required>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-sm-8">
					<a href="#" class="btn btn-primary" onclick="egresar(event)">
						Guardar
					</a>
				</div>
			</div>

		</form>

	</section>
</div>

@endsection

@section('jquery')

<script>
	
	function buscarProducto(event, codigo)
	{
		if(event.keyCode == 13)
		{
			event.preventDefault();
			if(codigo!='')
			{
				var success = function(response){

					if(!response.error)
					{
						$("#stock_id").val(response.stock.id);
						$("#nombre_hardware").val( response.producto.nombre_hardware );
					}
					else alert( response.mensaje )
				};
				var url = location.href+'/buscar?_codigo='+codigo.trim();

				$.getJSON(url, '', success);
				
			}else alert('Debe ingresar un codigo valido')
		}
	}

	function egresar(event)
	{
		event.preventDefault();
		var datos = ['codigo_hardware', 'cantidad', 'razon_salida_id', 'nombre_hardware', 'stock_id'];
		var formulario_completo =true;

		datos.forEach(function(dato, index){
			if( $("#"+dato).val() == '' ){
				formulario_completo = false;
			}
		});

		if( !formulario_completo){
			alert('Aun tienes cosas por completar');
			return false;
		}

		else{
			var success = function(response){
				if( !response.error )
				{
					datos.forEach(function(dato, index){
						$("#"+dato).val('');
					});
				}
				alert(response.mensaje);
			};
			var url = location.href+'/procesar'
			var formulario = $("#egreso").serialize();
			$.post(url, formulario, success);
		}
	}

</script>

@endsection