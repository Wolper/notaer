$(function () {
    var i = 1;
    var j = 1;
    var inputEscondido = $('input[type=submit]')[0];
    document.querySelector("[id='qteEtapas']").value = i;
//---------------------------------ENVIO DO FORMULÁRIO DE CADASTRO--------------------------------------
    $('#form').bind('submit', function (e) {
        e.preventDefault();


        var dados = $(this).serialize() + '&' + encodeURIComponent(inputEscondido.name) + '=' + encodeURIComponent(inputEscondido.value);

        $.ajax({
            type: 'POST',
            url: '__jsc/ajax.php',
            data: dados,
            dataType: 'json',
            success: function (json) {
//                alert("painel.php?exe=voo/update&create=true&emp=" + json.idvoo);
                window.location.replace("painel.php?exe=voo/update&create=true&emp=" + json.id_voo);
            }
        });
    });
//---------------------------------FIM DO ENVIO DO FORMULÁRIO DE CADASTRO--------------------------------------


    //---------------------------CONSTRUÇÃO DAS DIVS DE ETAPAS E CÁLCULO DE CAMPOS---------------------------------

    $(document.getElementsByClassName('pouso')).focusout()
    $('.pouso').focusout(function () {
        calculaTempoVoo();
    });

    var divContent = $('#etapas');
    var botaoAdicionar = $('a[data-id="1"]');



    //Ao clicar em adicionar ele cria uma linha com novos campos

    $(botaoAdicionar).click(function () {
        //criando instancia dom .conte4udoIndividual
        var linha = $('<div class="conteudoIndividual">' +
                '<div class="row"><div class="form-group col-md-1" style="display: none"><label><span class="field">Etapa:</span></label><input id="ne" class="form-control" type="text" value="' + (i + 1) + '"   readonly="" name="numero_etapa' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Origem:</span></label><input class="form-control" type="text" required="" name="origem' + i + '"/></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Destino:</span></label><input class="form-control" type="text" required=""  name="destino' + i + '"/></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Partida:</span></label><input class="form-control"  type="time" required=""  name="partida' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Decolagem:</span></label><input class="form-control decolagem"  type="time" required=""  name="decolagem' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Pouso:</span></label><input class="form-control pouso"  type="time" required=""  name="pouso' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Corte:</span></label><input class="form-control"  type="time" required=""  name="corte' + i + '" /></div></div>' +
                '<div class="row"><div class="form-group col-md-2"><label><span class="field">NG:</span></label><input class="form-control"  type="text" required=""  name="ng' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">NTL:</span></label><input class="form-control"  type="text" required=""  name="ntl' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Diu:</span></label><input class="form-control"  type="text" name="diurno' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Not:</span></label><input class="form-control"  type="text" name="noturno' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Pousos:</span></label><input class="form-control"  type="number" required="" name="qtepouso' + j + '" onblur="incrementaPouso(' + j + ')"/></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Gas:</span></label><input class="form-control"  type="number" required="" name="combustivel_consumido' + i + '" onblur="incrementaCombustivel(' + i + ')"/></div></div>' +
                '<a class="btn btn-danger" href="#" id="linkRemover">Remover Etapa</a></div>').appendTo(divContent);
        $('#removehidden').remove();
        i++;
        j++;
        $('<input type="hidden" name="quantidadeCampos" value="' + i + '" id="removehidden">').appendTo(divContent);
        document.querySelector("[id='qteEtapas']").value = i;

        //recuperando instancia #linkRemover e adicionando evento 
        linha.find("a").on("click", function () {
            decrementaCombustivel(i);
            decrementaPouso(j);
            $(this).parent(".conteudoIndividual").remove();
            i--;
            j--;
            document.querySelector("[id='qteEtapas']").value = i;
            return false;
        });

        return false;
    });

    //    adicionando o numero das etapas no formulário
    document.querySelector("[id='ne']").value = i;

    //    incrementando o valor do combustível da primeira etapa no cômputo total
    $("#cc").focusout(function () {
        if ($('#ctc').val() === 0) {
            document.querySelector("[id='ctc']").value = parseFloat(0);
        }
        document.querySelector("[id='ctc']").value = document.querySelector("[id='cc']").value;
    });

    $("#pp").focusout(function () {
        if ($('#tp').val() === 0) {
            document.querySelector("[id='tp']").value = parseFloat(0);
        }
        document.querySelector("[id='tp']").value = document.querySelector("[id='pp']").value;
    });

//    $("#historico").focusin(function () {
//        document.querySelector("[id='qteEtapas']").value = i;
//    });


//----------------------------FIM DA CONSTRUÇÃO DAS DIVS DE ETAPAS E CÁLCULO DE CAMPOS----------------------------

    //----------------------------------------------FUNÇÕES DIVERSAS-------------------------------------------------
});
function calculaTempoVoo() {

    if (!$('#datavoo').val()) {
        alert('Insira a data do voo!');
    } else {
        var datavoo = $('#datavoo').val().split("-");
        var pouso = $('.pouso').val().split(":");
        var decolagem = $('.decolagem').val().split(":");

        var timeCorte = new Date(datavoo[0], datavoo[1] - 1, datavoo[2], pouso[0], pouso[1]);
        var timePartida = new Date(datavoo[0], datavoo[1] - 1, datavoo[2], decolagem[0], decolagem[1]);

//    tempo total de voo (ttv)
        var tvpe = timeCorte - timePartida;
        var ttv = timeCorte - timePartida;

//     tempo total de voo em minutos(tttm)
        var ttvm = (ttv / 1000) / 60;

        $('#ttv').val(ttvm + ' min');
    }

}

function incrementaCombustivel(i) {
    var valorCelula = parseFloat($(document.getElementsByName('combustivel_consumido'.concat(i))).val());

    if ($('#ctc').val() === 0) {
        document.querySelector("[id='ctc']").value = parseFloat(0);
    }
    if (!isNaN(valorCelula)) {
        document.querySelector("[id='ctc']").value = parseFloat($('#ctc').val()) + valorCelula;
    }
}
function decrementaCombustivel(i) {
    var gasEtapa = 'combustivel_consumido'.concat(i - 1);
    var comb = $(document.getElementsByName(gasEtapa)).val();

    $('#ctc').val($('#ctc').val() - comb);
}

function incrementaPouso(j) {
    var valorCelula = parseFloat($(document.getElementsByName('qtepouso'.concat(j))).val());

    if ($('#tp').val() === 0) {
        document.querySelector("[id='tp']").value = parseFloat(0);
    }
    if (!isNaN(valorCelula)) {
        document.querySelector("[id='tp']").value = parseFloat($('#tp').val()) + valorCelula;
    }
}
function decrementaPouso(j) {
    var gasEtapa = 'qtepouso'.concat(j - 1);
    var comb = $(document.getElementsByName(gasEtapa)).val();

    $('#tp').val($('#tp').val() - comb);
}
