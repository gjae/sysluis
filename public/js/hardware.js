/**
 * FORMAS DE IDENTIFICAR UNA SOLICITUD AJAX:
 * LAS FUNCIONES $.getJSON, $.get, $.post
 * SOM FUNCIONES ENCARGADAS DE HACER SOLICITUDES AJAX AL SERVIDOR
 * ($.getJSON envia una solicitud GET RECIBE OBJETOS JSON COMO RESPUESTA)
 */

$(document).ready(function() {

        $('#dataTables-example').DataTable({
            responsive: true
        });


        $(".btn-forms").click(function(){
            var dataForms = $(this).attr('formulario');
            $(".modal-footer").html("");
            modal = $('#modal_hardware');
            modal.modal('show');

            var id = $(this).attr('data-id');

            var url = location.href+'/formularios/'+dataForms;

            url += ( id != undefined ) ? '?hardware_id='+id : '';
            

            $("#verificando").html('<div class="loader"></div>');
            $.getJSON(url, '', function(response){
                if(! response.fail)
                {
                    $("#formulario").html(response.formulario);
                }
            });
            $("#verificando").html('');
        });


        $("#modal-click").click(function(){
            var datos = $("#insertar_datos");
            var url = location.href+'/'+datos.attr('data-url');

            if( datos.serialize().indexOf('=&') != -1){
                alert("APARENTEMENTE AUN TIENES CAMPOS SIN COMPLETAR; DEBES LLENAR TODO EL FORMULARIO PARA PODER CONTINUAR CON LA OPERACION");
                return false;
            }
            $.post(url, datos.serialize(),(resp) =>{
                alert(resp.mensaje)
                if(! resp.fail)
                    location.reload()
            });

        });

        $(".delete").click(function(){
            if( confirm('¿Seguro que desea realizar esta acción?'))
            {
                var id = $(this).attr('data-id');
                var token = $(this).attr('token');
                var url = location.href +'/'+$(this).attr('role');

                $.post(url, {'id': id, '_token': token}, function(response){
                    
                        alert(response.mensaje);
                        location.reload()
                });
            }
        });
        var id = 0;

        $(".edit").click(function(){

            var url = location.href ;
            $.getJSON(url+ '/consultar/'+$(this).attr('data-id'), '', function(response){
                if(response.nombre_categoria != null){

                }

            });
        });
});

function cargarDatos(event, form){
    event.preventDefault();
    var datos = [
        'nombre_hardware', 'codigo_hardware', 'imagen', 'categoria_id', 'precio'
    ];
    
    var i = 0;
    var input = "";
    for(i = 0; i < datos.length; i++){
        input = "form."+datos[i]+".value";

        if( eval(input) == "" ){
            alert("Aún tiene campos por completar en el formulario.")
            return false;
        }
    }
    form.submit()
}
