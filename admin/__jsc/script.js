$(function () {
    i = 1;

    var inputEscondido = $('input[type=submit]')[0];
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
                window.location.replace("painel.php?exe=voo/update&create=true&emp=" + json.idvoo);
            }
        });
    });
//---------------------------------FIM DO ENVIO DO FORMULÁRIO DE CADASTRO--------------------------------------




    //---------------------------CONSTRUÇÃO DAS DIVS DE ETAPAS E CÁLCULO DE CAMPOS---------------------------------

    $('#corte').focusout(function () {
        calculaTempoVoo();
    });

    var divContent = $('#etapas');
    var botaoAdicionar = $('a[data-id="1"]');



    //Ao clicar em adicionar ele cria uma linha com novos campos

    $(botaoAdicionar).click(function () {
        //criando instancia dom .conte4udoIndividual
        var linha = $('<div class="conteudoIndividual">' +
                '<input id="ne" class="form-control" type="hidden" value="' + (i + 1) + '"   readonly="" name="numero_etapa' + i + '" />' +
                '<div class="form-group col-md-2"><label><span class="field">Origem:</span></label><input class="form-control" type="text" name="origem' + i + '"/></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Destino:</span></label><input class="form-control" type="text" name="destino' + i + '"/></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Partida:</span></label><input class="form-control"  type="time" name="partida' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Decolagem:</span></label><input class="form-control"  type="time" name="decolagem' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Pouso:</span></label><input class="form-control"  type="time" name="pouso' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Corte:</span></label><input class="form-control"  type="time" name="corte' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">NG:</span></label><input class="form-control"  type="text" name="ng' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">NTL:</span></label><input class="form-control"  type="text" name="ntl' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Diu:</span></label><input class="form-control"  type="text" name="diurno' + i + '" /></div>' +
                '<div class="form-group col-md-2"><label><span class="field">Not:</span></label><input class="form-control"  type="text" name="noturno' + i + '" /></div>' +
                '<div class="form-group col-md-1"><label><span class="field">Pousos:</span></label><input class="form-control"  type="text" name="qtepouso' + i + '"/></div>' +
                '<div class="form-group col-md-1"><label><span class="field">Gas:</span></label><input id="' + i + '" class="form-control"  type="text" name="combustivel_consumido' + i + '" onblur="blurFunction(' + i + ')"/></div>' +
                '<a class="btn btn-danger" href="#" id="linkRemover">Remover Etapa</a></div>').appendTo(divContent);
        $('#removehidden').remove();
        i++;
        $('<input type="hidden" name="quantidadeCampos" value="' + i + '" id="removehidden">').appendTo(divContent);

        //recuperando instancia #linkRemover e adicionando evento 
        linha.find("a").on("click", function () {
            $(this).parent(".conteudoIndividual").remove();
            i--;
            document.querySelector("[id='tp']").value = i;
            return false;
        });

        document.querySelector("[id='tp']").value = i;
        return false;


    });

    //    adicionando o numero das etapas no formulário
    document.querySelector("[id='ne']").value = i;

    //    incrementando o valor do combustível da primeira etapa no cômputo total
    $("#cc").focusout(function () {
        document.querySelector("[id='tp']").value = i;
        if ($('#ctc').val() === 0) {
            document.querySelector("[id='ctc']").value = parseFloat(0);
        }
        document.querySelector("[id='ctc']").value = document.querySelector("#cc").value;
    });


//----------------------------FIM DA CONSTRUÇÃO DAS DIVS DE ETAPAS E CÁLCULO DE CAMPOS----------------------------


    //----------------------------------------------FUNÇÕES DIVERSAS-------------------------------------------------
});
function calculaTempoVoo() {

    if (!$('#datavoo').val()) {
        alert('Insira a data do voo!');
    } else {
        var datavoo = $('#datavoo').val().split("-");
        var corte = $('#corte').val().split(":");
        var partida = $('#partida').val().split(":");

        var timeCorte = new Date(datavoo[0], datavoo[1] - 1, datavoo[2], corte[0], corte[1]);
        var timePartida = new Date(datavoo[0], datavoo[1] - 1, datavoo[2], partida[0], partida[1]);

//    tempo total de voo (ttv)
        var tvpe = timeCorte - timePartida;
        var ttv = timeCorte - timePartida;

//     tempo total de voo em minutos(tttm)
        var ttvm = (ttv / 1000) / 60;

        $('#ttv').val(ttvm + ' min');
    }

}

function blurFunction(i) {

    if ($('#ctc').val() === 0) {
        document.querySelector("[id='ctc']").value = parseFloat(0);
    }
    document.querySelector("[id='ctc']").value = parseFloat($('#ctc').val()) + parseFloat(document.getElementById(i).value);
}
