@extends('layouts.dashboard_layout')

@section('titulo', 'Consulta las facturas del sistema')


@section('contenedor')

<div class="container">
	<div class="row">
		
		<div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
			
			<label for="">Numero de factura</label>
			<input type="text" id="factura_id" placeholder="Ingresa el numero de factura y presione la tecla [ENTER]" name="factura_id" class="form-control">
			<blockquote>
				Ingrese el numero de la factura a consultar y presione enter
			</blockquote>

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
				else
				{
					var url = "http://"+location.host+"/consultar/factura-online?factura_id="+numero.val()
					window.open(url, "_blank");
				}
			});
		}
	})

})

</script>

@endsection
