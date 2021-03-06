<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('titulo')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- MIS ESTILOS -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @section('css')
    @show
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

    <div id="wrapper">
         <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    {{ Auth::user()->empleado->persona->nombres }}
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a href="{{ url('logout') }}">
                       Salir de mi cuenta <span class="glyphicon glyphicon-log-out"></span> 
                    </a>
                   <!-- <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#">
                                <span class="glyphicon glyphicon-pencil"></span>
                                Mi Cuenta
                            </a>
                        </li>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('logout') }}"><span class="glyphicon glyphicon-log-out"></span>
                            Salir de mi cuenta
                        </a>
                        </li>
                    </ul>-->
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div style="text-align: center;"">
                    <img src="{{ 'http://localhost/sysluis/public/img/'.App\Empresa::first()->logo }}" alt="" style="max-height: 136px; max-width: 250px;" class="responsive-img">
                    <br>
                    <strong>{{ App\Empresa::first()->personalidad.'-'.App\Empresa::first()->rif }}</strong>
        
                </div>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="{{ url('dashboard') }}">
                                 Estadisticas personales
                            </a>
                        </li>
                        @foreach($modulos as $modulo)
                            <li>
                                <a href="#">{{ $modulo->nombre_modulo }}<span class="caret"></span></a>
                                <ul class="nav nav-second-level">
                                    @foreach( \App\Modulo::getProgramas($modulo->id) as $programa)
                                    <li>
                                        <a href="{{ url('dashboard/'.$programa->url_programa) }}"> {{ $programa->nombre_programa }} </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
         <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- AQUI VA EL PAGE HEADER SI SE NECESITARA -->

                        <!-- AQUI TERMINA EL PAGE HEADER -->
                        @section('contenedor')
                        @show
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>



<body>

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    <script src="{{ asset('js/funciones.js') }}"></script>

    @section('jquery')
    @show

</body>

</html>
