@extends('layouts.dashboard_layout')

@section('titulo', 	Auth::user()->empleado->persona->nombres)

@section('contenedor')

<div class="container">

	<div class="row">
		<div class="container">
			<div class="row">
				<div class="col sm-8">
					<h3 class="page-header">Estadisticas personales</h3>
				</div>
			</div>
		</div>
		@foreach($asignaciones as $asignacion)
		<div class="col-sm-3">
            <div class="panel panel-{{$colores[ strtolower($asignacion->nombre_estatus) ]}}">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-5 text-right">
                            <div class="huge">{{ $asignacion->asignaciones }}</div>
                            <div>{{ $asignacion->nombre_estatus }}S</div>
                        </div>
                    </div>
                </div>
                <!--<a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalles</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>-->
            </div>
        </div>
        @endforeach

	</div>

</div>

@endsection
