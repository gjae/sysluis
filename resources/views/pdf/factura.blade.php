@extends('layouts.reportes')

@section('content')

<table border="0" cellspacing="0" cellpadding="0" align="center">
	
	<tr>
		<td>
			Fecha
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						&nbsp;&nbsp;&nbsp; {{ $servicio->created_at->format('d') }} &nbsp;&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;&nbsp;&nbsp; {{ $servicio->created_at->format('m') }} &nbsp;&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;&nbsp;&nbsp; {{ $servicio->created_at->format('Y') }} &nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</td>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			No. de control 00 - <span style="color: red;"> {{ $servicio->id }} </span>
		</td>
	</tr>

</table>

<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
			Nombre o razón social: {{ $servicio->cliente->persona->nombres.' '.$servicio->cliente->persona->apellidos }}
		</td>
	</tr>
	<tr>
		<td>
			Dirección fiscal: {{ $servicio->cliente->persona->direccion }}
		</td>
	</tr>
	<tr>
		<table border="1" cellspacing="0" cellpadding="0" align="center">  
			<tr>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp; Tlf.: {{ $servicio->cliente->persona->telefono_personal }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;
					Cedula o RIF: {{ $servicio->cliente->persona->cedula }}
					&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;
					Forma de pago: {{ $servicio->modalidad_pago->nombre_modalidad }}
					&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			
		</table>
	</tr>
</table>

<table border="1" align="center" style="text-align: center;" cellspacing="0" cellpadding="0">
	
	<thead>
		<tr style="background-color: #f3f3f3;">
			<th>
				&nbsp;&nbsp;&nbsp;&nbsp;Cantidad &nbsp;&nbsp;&nbsp;&nbsp;
			</th>
			<th>
				&nbsp;&nbsp;&nbsp;&nbsp;Descripcion&nbsp;&nbsp;&nbsp;&nbsp;
			</th>
			<th>
				&nbsp;&nbsp;&nbsp;&nbsp;P.UNITARIO&nbsp;&nbsp;&nbsp;&nbsp;
			</th>
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp; <strong> Abono </strong>&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<th>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</th>
		</tr>
	</thead>
	
	<tbody>
		@foreach($detalles as $detalle)
		<tr>
			<td>
				{{ $detalle->comprados }}
			</td>
			<td>
				{{ $detalle->nombre_hardware }}
			</td>
			<td>
				{{  number_format($detalle->precio,2 ) }}
			</td>
			<td>
				{{ number_format(0.00,2) }}
			</td>
			<td> 
				{{ number_format( ($detalle->precio * $detalle->comprados), 2 ) }} 
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<br><br>
<table border="1" cellpadding="0" cellspacing="0" align="center">
	<thead>
		<tr>
			<th> SUB-TOTAL </th>
			<th> AJUSTES </th>
			<th> TOTAL DE BASE IMPONIBLE </th>
			<th> % IVA </th>
			<th> TOTAL A PAGAR </th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th> {{ number_format($servicio->subtotal,2 ) }} </th>
			<th> {{ number_format(0.00, 2) }} </th>
			<th> {{ number_format($servicio->subtotal,2 ) }} </th>
			<th> {{ (env('IVA')*100)." %" }} </th>
			<th> {{ number_format($servicio->total,2 ) }} </th>
		</tr>
	</tbody>
</table>
@endsection