<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura - Servicios</title>
</head>
<body>

<style>
	
	body{
		font-family: 'Helvetica';

	}
	.separator{

		border: 1px solid #327BAD;
		padding-top: 0.5px;
		padding-bottom: 0.5px;
		background-color: #327BAD;
		margin-bottom: -13px;
		margin-top: -13px;
	}
	.header{
		margin-top: -7px;
		margin-bottom: 0px;
	}

	#header{
		font-family: 'Helvetica';
		text-align: center;
	}
	#datos-fiscales{
		margin-left: 23px;
		margin-right: 23px;
		margin-top: 7px;
	}
	#inf-servicios{
		margin-left: 23px;
		margin-right: 23px;
		margin-top: 7px;
	}
	.nro-control{
		margin-top: -55px;
	}

</style>

<div id="header">
	
	<p>
		<h3>
			Soluciones informatica en general. <br>
			Programacion, diseño web, soporte tecnico y desarrollo de software
			en general <br>
			RIF.: 
		</h3>

		<div class="separator"></div>
		<h4>
			Direccion...
		</h4>
		<div class="separator"></div>
	</p>
	
</div>
@section('cuerpo')
@show
</body>
</html>