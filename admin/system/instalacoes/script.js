$(function () {
    $('#in_anv').css('color','blue');
    
    
    
//    $('#in_anv').focusout(function () {
//
//        if (($('#in_anv').val()) > 0) {
//            MascaraTime();
//        }
//
//        return false;
//    });
});

function MascaraTime() {

    var horaVoo = $('#in_anv').val();
    

        if(mascaraInteiro(horaVoo) === false){
                event.returnValue = false;
        }       

    return formataCampo(horaVoo, '0000:00', event);
}

function mascaraInteiro() {
    if (event.keyCode < 48 || event.keyCode > 57) {
        event.returnValue = false;
        return false;
    }
    return true;
}


function formataCampo(campo, Mascara, evento) {
    var boleanoMascara;

//    var Digitato = evento.keyCode;
    var Digitato = 6;
    exp = /\-|\.|\/|\(|\)| /g;
    
    campoSoNumeros = campo.toString().replace(exp, "");
//    console.log(Digitato);
    var posicaoCampo = 0;
    var NovoValorCampo = "";
    var TamanhoMascara = campoSoNumeros.length;

    if (Digitato !== 6) { // backspace 
        for (i = 0; i <= TamanhoMascara; i++) {
            boleanoMascara = (Mascara.charAt(i) === ":");
            boleanoMascara = boleanoMascara || Mascara.charAt(i) === " ";
            if (boleanoMascara) {
                NovoValorCampo += Mascara.charAt(i);
                TamanhoMascara++;
            } else {
                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                posicaoCampo++;
            }
        }
        campo.value = NovoValorCampo;
        return true;
    } else {
        return true;
    }
}