<?php  

/*
/-------------------------------------------------------------
/	CONFIGURACION DE MODULOS PRE CARGADOS EN EL SISTEMA
/-------------------------------------------------------------
/ 	ESTE ARCHIVO CONTIENE TODOS LOS MODULOS DEL SISTEMA
/ 	PARA EFECTOS DE LA INSTALACIÓN DEL SISTEMA 
/	ESTE ARCHIVO CONTIENE TODOS LOS MODULOS POR DEFECTO QUE
/	POSEE EL SISTEMA. PARA EFECTOS DE CONTROL, SE RECOMIENDA
/	REGISTRAR LOS MODULOS EN ESTE APARTADO.
/-------------------------------------------------------------
/		ESTRUCTURA PARA REGISTRAR UN MODULO
/-------------------------------------------------------------
/
/	[
/		*--- ATRIBUTOS DEL MODULO ---*
/		programas[del modulo] => [ *--- ATRIBUTOS DEL PROGRAMA --* ]
/	]
/
/	* SI EL MODULO ES CREADO POSTERIOR A LA INSTALACIÓN, ENTONCES
/		SE RECOMIENDA REGISTRAR EL MODULO Y SUS PROGRAMAS MANUALMENTE EN LA
/		BASE DE DATOS *
*/

return [
	
	/**
	 * MODULO DE GESTION DE USUARIOS (MODULO PRINCIPAL)
	 */
	
	[
		'nombre_modulo'		=> 'Gestion de usuarios',
		'descripcion_modulo' => 'Modulo para gestionar usuarios del sistema',
		'url_modulo'	=> 'usuarios',
		'programas'		=> [

			//PROGRAMAS DEL MODULO
			[
				'nombre_programa'	=> 'Usuarios del sistema' ,
				'descripcion_programa' => 'Programa para listar, ver, suprimir y crear usuarios en el sistema',
				'url_programa'	=> 'usuarios/Usuarios',
			],

			//FIN DE LOS PROGRAMAS DEL MODULO
		],
	],

	/**
	 * GESTION DE FACTURAS: MANEJA TODO LO REFERENTE A FACTURAS
	 */

	[
		'nombre_modulo' => 'Gestion de facturas',
	    'descripcion_modulo'	=> 'Modulo para gestionar facturas',
	    'url_modulo'	=> 'facturacion',

	    //PROGRAMAS DEL MODULO
	    'programas'		=> [

	      	[
	      		'nombre_programa'	=> 'Emisión de facturas',
	       		'descripcion_programa'	=> 'Programa para emitir facturas',
	       		'url_programa'	=> 'facturacion/Facturacion',
	      	],

	      	[
	      		'nombre_programa'	=> 'Reportes',
	       		'descripcion_programa'	=> 'Archvio para generar todos los reportes posibles sobre facturas',
	       		'url_programa'	=> 'facturacion/Reportes',
	      	],

	      	[
	      		'nombre_programa'	=> 'Facturas emitidas',
	       		'descripcion_programa'	=> 'Programa para buscar facturas emitidas por el sistema',
	       		'url_programa'	=> 'facturacion/BuscarFacturas',
	      	],

	    ],

	],

	/**
	 * 	MODULO PARA GESTIONAR EL INVENTARIO
	 * 	TIENE COMO PROGRAMAS EL MANEJO DE LAS CATEGORIAS Y LA GESTION
	 * 	DE EQUIPOS DE HARDWARE
	 */
	[
		'nombre_modulo'		=> 'Gestion de inventario',
		'descripcion_modulo' => 'Modulo para gestionar todo lo relacionado al inventario',
	    'url_modulo'		 => 'inventario',
	    'programas'			 => [

	    	//PROGRAMAS DEL MODULO
	    	[
	    		'nombre_programa'	=> 'Control de equipos' ,
	        	'descripcion_programa' => 'Programa para controlar el stock de equipos',
	        	'url_programa'	=> 'inventario/Hardware'
	        ],

	    	[
	    		'nombre_programa'	=> 'Manejo de categorias',
	        	'descripcion_programa' => 'Programa para manipular categorias',
	        	'url_programa' => 'inventario/Categorias',
	        ],
	        [
	        	'nombre_programa' => 'Ingreso de mercancia',
	        	'descripcion_programa' => 'Programa para gestinar el ingreso o reabastecimiento de mercancias',
	        	'url_programa' => 'inventario/Ingresos',

	        ],
	        [
	        	'nombre_programa' => 'Egreso de mercancia',
	        	'descripcion_programa' => 'Programa para gestinar el egreso o reabastecimiento de mercancias',
	        	'url_programa' => 'inventario/Egresos',

	        ],
	        [
	        	'nombre_programa' => 'Metodos de egreso',
	        	'descripcion_programa' => 'Gestion de tipos de egresos, programa usado para controlar los metodos que pueden ser usados para el egreso de materiales y/o productos',
	        	'url_programa' => 'inventario/MetodosEgreso',

	        ],
	  		//FIN DE LOS PROGRAMAS DEL MODULO
	 	], 
	],

	//FIN DEL MODULO DE GESTION DE INVENTARIO
	
	//MODULO DE SERVICIOS
	//
	[
		'nombre_modulo' => 'Servicios',
		'descripcion_modulo' => 'Modulo de manejo de servicios, creación de tipos, listado
									de solicitudes de servicios, etc..',
		'url_modulo'	=> 'servicios',

		'programas'	=> [
			//PROGRAMAS DEL MODULO
			[
				'nombre_programa' => 'Solicitudes de servicios',
				'descripcion_programa' => 'Este programa puede ver las solicitudes de servicios entrantes',
				'url_programa'	=> 'servicios/Solicitudes',
			],

			[
				'nombre_programa' => 'Facturación de servicio',
				'descripcion_programa' => 'Programa para facturar la solicitud de un servicio',
				'url_programa' => 'servicios/Facturar',
			],

			[
				'nombre_programa' => 'Mis asignaciones',
				'descripcion_programa' => 'Programa para facturar la solicitud de un servicio',
				'url_programa' => 'servicios/Asignaciones',
			],
			[
				'nombre_programa' => 'Log de problemas resueltos',
				'descripcion_programa' => 'Programa para ver el listado de logs de problemas resueltos por los usuarios',
				'url_programa' => 'servicios/Logs',
			],

			//FIN DE LOS PROGRAMAS DEL MODULO

		],

	],
	[
		'nombre_modulo' => 'Reportes',
		'descripcion_modulo' => 'MODULO DE GEERACION DE REPORTES DEL SISTEMA',
		'url_modulo'	=> 'reportes',

		'programas'	=> [
			//PROGRAMAS DEL MODULO
			[
				'nombre_programa' => 'Facturas por personas',
				'descripcion_programa' => 'PROGRAMA PARA GENERAR REPORTES DE FACTURAS POR PERSONAS',
				'url_programa'	=> 'reportes/PorPersona',
			],

			[
				'nombre_programa' => 'Total de facturas en tiempo',
				'descripcion_programa' => 'PROGRAMA PARA GENERAR REPORTES DE FACTURAS POR TIEMPO: TOTALES DE TODAS LAS FACTURAS ENTRE DOS FECHAS',
				'url_programa' => 'reportes/PorTiempo',
			],

			[
				'nombre_programa' => 'Estadisticas por usuarios',
				'descripcion_programa' => 'PROGRAMA PARA REPORTES DE ESTADISTICAS POR USUARIO: CANTIDADES DE VENTAS, REPARACIONES ETC..',
				'url_programa' => 'reportes/Estadistico',
			],

			//FIN DE LOS PROGRAMAS DEL MODULO

		],

	],
];