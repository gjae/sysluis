@extends('pdf.layout_facturas')

@section('body')
<br><br>
	<table width="100%" class="table table-bordered">
		<thead>
			<tr>
				<th>Número</th>
				<th>Fecha de emisión</th>
				<th>Hora de emisión</th>
				<th>Subtotal</th>
				<th>IVA</th>
				<th>Total</th>
			</tr>
		</thead>

		<tbody>
			@foreach($facturas as $factura)
			<tr>
				<td>{{ $factura->id }}</td>
				<td>{{ $factura->created_at->format('d-m-Y') }}</td>
				<td> {{ $factura->created_at->format('h:i A') }} </td>
				<td>{{ number_format($factura->subtotal,2 ) }}</td>
				<td> {{ number_format($factura->iva, 2) }} </td>
				<td> {{ number_format($factura->total,2 ) }} </td>
			</tr>
			@endforeach
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>{{ number_format($facturas->sum('subtotal'),2 ) }}</td>
				<td> {{ number_format($facturas->sum('iva'), 2) }} </td>
				<td> {{ number_format($facturas->sum('total'),2 ) }} </td>
			</tr>
		</tbody>
	</table>

	
@endsection