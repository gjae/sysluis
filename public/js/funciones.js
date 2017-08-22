var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

function soloTexto(evento, input, longitud = 50){
    var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

       // alert("input")
<<<<<<< HEAD
        if( ( /\d|\u00C0|\u017F|[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\{\}\[\]\\\/]/.test(input.value) ) ){
            alert("El nombre de una persona no debe contener simbolos especiales ni numericos.")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        }
        if(input.value.length > 50)
        {
            input.value = input.value.substring(0, (input.value.length - 1))
        }
=======
    if( ( /\d|\u00C0|\u017F|[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\{\}\[\]\\\/]/.test(input.value) ) ){
        alert("EL NOMBRE DE UNA PERSONA NO PUEDE CONTENER SIMBOLOS ESPECIALES NI NÚMEROS")
        input.value = input.value.substring(0 , (input.value.length - 1) )
    }
    if(input.value.length > longitud)
    {
        input.value = input.value.substring(0, (input.value.length - 1))
>>>>>>> 6980015e514d1685fd039cf8eeda13a228337a82
    }
}

<<<<<<< HEAD
    function soloNumeros(evento, input, longitud){
        var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )
        if( !(/^[0-9]+$/.test( input.value )) && key ){
            alert("El campo que intenta utilizar solo debe contener carácteres numericos y de tener una longitud máxima de "+longitud+ " CARACTERES")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        }
        if(input.value.length > longitud)
            input.value = input.value.substring(0, (input.value.length - 1))
=======
function soloNumeros(evento, input, longitud){
        
    var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

    if( !(/^[0-9]+$/.test( input.value )) && key ){
     //   alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
        input.value = input.value.substring(0 , (input.value.length - 1) )
>>>>>>> 6980015e514d1685fd039cf8eeda13a228337a82
    }
    if(input.value.length > longitud)
        input.value = input.value.substring(0, (input.value.length - 1))
}

function validarCedula(cedula, longitud)
{   
 //   var key = (evento.keyCode!= 9 && evento.keyCode != 8 && evento.keyCode != 38 && evento.keyCode != 39 && evento.keyCode != 40 && evento.keyCode != 37   )

    input = document.getElementById(cedula)
    if( !(/^[0-9\-]+$/.test( input.value )) || input.value.length > longitud){
<<<<<<< HEAD
        alert("El campo que intenta utilizar solo debe contener carácteres numericos y de tener una longitud máxima de "+longitud+ " CARACTERES")
=======
        //alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
>>>>>>> 6980015e514d1685fd039cf8eeda13a228337a82
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
        alert('Formato de fecha inválida.')
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