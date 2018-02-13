$(function () {
    $('#frequencia').change(function () {
        var freq = document.getElementById('frequencia');
        var valor = freq.options[freq.selectedIndex].text;

        selecionaFrequencia(valor);

    });
});

function selecionaFrequencia(v) {
    if ((v === 'M/H') || (v === 'D/H')) {
        if (!$('#composta').length > 0) {
            var composta = '<div id="composta" class="row"><div class="form-group col-md-3"><label><span class="field">Frequencia/Hora:</span></label><input class="form-control" type="number" name="frequencia_for_time" placeholder="só números" /></div><div class="form-group col-md-3"><label><span class="field">Frequencia/M/D:</span></label><input class="form-control" type="text" name="frequencia_for_date" placeholder="só números" /></div></div>';
            $('#divPai').prepend(composta);
        }
        $('#simples').remove();
    } else {
        if (!$('#simples').length > 0) {
            var simples = '<div id="simples" class="row"><div class="form-group col-md-3"><label><span class="field">Frequencia:</span></label><input class="form-control" type="number" name="frequencia_for_time" placeholder="só números" /></div></div></div>';
            $('#divPai').prepend(simples);
        }
        $('#composta').remove();
    }
}
