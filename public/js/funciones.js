
    function soloTexto(evento, input){
       // alert("input")
        if( ( /\d|\u00C0|\u017F|[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\{\}\[\]\\\/]/.test(input.value) ) ){
            alert("EL NOMBRE DE UNA PERSONA NO PUEDE CONTENER SIMBOLOS ESPECIALES NI NÚMEROS")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        }
        if(input.value.length > 50)
        {
            input.value = input.value.substring(0, (input.value.length - 1))
        }
    }

    function soloNumeros(evento, input, longitud){
        alert(evento.keyCode)
        var key = (evento.keyCode == 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )
        if( !(/^[0-9]+$/.test( input.value )) || key ){
            alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        }
        if(input.value.length > longitud)
            input.value = input.value.substring(0, (input.value.length - 1))

    }

function validarCedula(cedula, longitud)
{
    input = document.getElementById(cedula)
    if( !(/^[0-9\-]+$/.test( input.value )) || input.value.length > longitud){
        alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
        input.value = input.value.substring(0 , (input.value.length - 1) ) 
     }
}

function validarPrecio(evento, input){
    if( !(/^[0-9]+([.][0-9]+)?$/.test( input.value )) ){
        input.value = input.value.substring( 0, ( input.value.length - 1 ) );
    }
}

function validarFormatoFecha(evento, input, returned = false){
    if (  input.value.length == 10 && !(/^(\d{4})-(\d{1,2})-(\d{1,2})$/.test(input.value) )  ){
        alert('FORMATO DE FECHA INVALIDA')
        input.value = ""
        if(returned)
            return false;
    }   
    if( returned )
        return true
}

