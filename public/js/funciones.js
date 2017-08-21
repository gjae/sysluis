var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

function soloTexto(evento, input, longitud = 50){
    var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

       // alert("input")
    if( ( /\d|\u00C0|\u017F|[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\{\}\[\]\\\/]/.test(input.value) ) ){
        alert("EL NOMBRE DE UNA PERSONA NO PUEDE CONTENER SIMBOLOS ESPECIALES NI NÚMEROS")
        input.value = input.value.substring(0 , (input.value.length - 1) )
    }
    if(input.value.length > longitud)
    {
        input.value = input.value.substring(0, (input.value.length - 1))
    }
}

function soloNumeros(evento, input, longitud){
        
    var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

    if( !(/^[0-9]+$/.test( input.value )) && key ){
     //   alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
        input.value = input.value.substring(0 , (input.value.length - 1) )
    }
    if(input.value.length > longitud)
        input.value = input.value.substring(0, (input.value.length - 1))
}

function validarCedula(cedula, longitud)
{   
 //   var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

    input = document.getElementById(cedula)
    if( !(/^[0-9\-]+$/.test( input.value )) || input.value.length > longitud){
        //alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
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

function textoYNumero(evento, input, longitudMaxima){

    var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

    if( evento.keyCode != 32 && !(/^[a-zA-Z0-9_]/.test(input.value)) ||  input.value.length > longitudMaxima ){
        input.value = input.value.substring(0, (input.value.length - 1))
    }
}