@extends('layouts.reportes')

@section('content')

<table border="0" cellspacing="0" cellpadding="0" align="center">
	
	<tr>
		<td>
			Fecha
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						&nbsp;&nbsp;&nbsp; {{ $factura->created_at->format('d') }} &nbsp;&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;&nbsp;&nbsp; {{ $factura->created_at->format('m') }} &nbsp;&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;&nbsp;&nbsp; {{ $factura->created_at->format('Y') }} &nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</td>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			No. de control 00 - <span style="color: red;"> {{ $factura->id }} </span>
		</td>
	</tr>

</table>

<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
			Nombre o razón social: {{ $factura->cliente->persona->nombres.' '.$factura->cliente->persona->apellidos }}
		</td>
	</tr>
	<tr>
		<td>
			Dirección fiscal: {{ $factura->cliente->persona->direccion }}
		</td>
	</tr>
	<tr>
		<table border="1" cellspacing="0" cellpadding="0" align="center">  
			<tr>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp; Tlf.: {{ $factura->cliente->persona->telefono_personal }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;
					Cedula o RIF: {{ $factura->cliente->persona->cedula }}
					&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;&nbsp;
					Forma de pago: {{ $factura->modalidad_pago->nombre_modalidad }}
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
		<tr>
			<td>
				1
			</td>
			<td>
				{{ $factura->concepto }}
			</td>
			<td>
				{{ number_format($factura->solicitud->precio ,2 )  }}
			</td>
			<td>
				{{ number_format($factura->solicitud->abono,2) }}
			</td>
			<td> {{ number_format( $factura->total, 2 ) }} </td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
		</tr>
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
			<th> {{ number_format($factura->total, 2) }} </th>
			<th> {{ number_format(0.00, 2) }} </th>
			<th> {{ number_format($factura->total, 2) }} </th>
			<th> {{ (env('IVA')*100)." %" }} </th>
			<th> {{ number_format($factura->total, 2) }} </th>
		</tr>
	</tbody>
</table>
@endsection