$(document).ready(function(){

	$('#dataTables-example').DataTable({
            responsive: true
     });


	/*
	*	APERTURA DE LOS MODALES PARA FORMULARIOS
	 */
	$(".btn_forms").click(function(){
		var btn = $(this);
		var url = location.href +'/'+$(this).attr('data-url')+'/'+$(this).attr('data-solicitud');
		
		if( $(this).attr('data-solicitud') == 'crear_solicitud' )
			$("#modal-footer").addClass('hidden');
		else
			$("#modal-footer").removeClass('hidden')
		//alert(url)
		var form = $("#modal_forms");
		var id = btn.attr('data-solicitud');
		form.modal('show');
		$.getJSON(url, '', function(response){
			 $("#form-inputs").html(response.formulario);
		});

	});

	$("#modal-click").click(function(){
		var datos = $("#cargar_info").serialize();
		var form = document.getElementById("cargar_info")
		var url = location.href +'/'+$("#accion").val();
		
	
		if( form.total.value =="" || form.precio.value == 0){
			alert("Usted aun posee campos del formulario por completar");
			return false;
		}

		if(confirm('¿Esta seguro de realizar esta operación?'))
		{
			$.post(url, datos, function(response){
				alert(response.mensaje);
				location.reload();
			});
		}
	});
});

function calcularTotal(event)
{	
	if(event.keyCode == 13)
	{
		event.preventDefault()

		var por_iva = document.getElementById('iva');
		var abono = document.getElementById('abono');
		var precio = document.getElementById('precio');
		$("#iva_servicio").val( parseFloat(precio.value) *parseFloat(por_iva.value)  )
		$("#total").val( parseFloat(precio.value) + ( parseFloat(precio.value) *parseFloat(por_iva.value) ) - parseFloat(abono.value) ); 
	}
}

function crear_solicitud(event, form){
	event.preventDefault();
	alert("izzi")
	//$("#cargar_info").submit();
}