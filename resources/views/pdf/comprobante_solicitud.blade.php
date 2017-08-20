@extends('pdf.layout_facturas')

@section('body')


<table border="1" cellpadding="0" cellspacing="0" >
	
<tr align="center">
	<td >
		<h3>
			COMPROBANTE DE SOLICITUD &nbsp;&nbsp;&nbsp;&nbsp;
		</h3>
	</td>
</tr>
<tr>
	<td>
		<table border="1" cellpadding="0" cellspacing="0">
			
			<tr align="center">
				<td>&nbsp;&nbsp;Cliente: {{ $datos->cliente->persona->nombres.' '.$datos->cliente->persona->apellidos }}&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;Cédula: {{ $datos->cliente->persona->cedula }}&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;Tipo de solicitud: {{ $datos->tipo->denominacion }}&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;Categoría: {{ $datos->categoria->nombre_categoria }}&nbsp;&nbsp;</td>
			</tr>

		</table>
	</td>
</tr>
<tr align="center">
	<td>
		<strong>Su código de solicitud es el siguiente:</strong>
		<h1>{{ $datos->codigo_solicitud }}</h1>
		<br>
		<p>Fecha de solicitud: {{ $datos->created_at->format('d-m-Y') }}</p>
	</td>
</tr>

</table>

@endsection