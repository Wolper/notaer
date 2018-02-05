$(function () {
    $('#frequencia').change(function () {
        var freq = document.getElementById('frequencia');
        var freq = document.querySelector("[id='frequencia']");
        var valor = freq.options[freq.selectedIndex].text;

        selecionaFrequencia(valor);


    });
});

function selecionaFrequencia(v) {
    if ((v === 'M/H') || (v === 'D/H')) {
        $('#freq_composta').css('display', 'inline');
        $('#freq_simples').css('display', 'none');
        $('#freq_simples').remove();
    } else {
        $('#freq_simples').css('display', 'inline');
        $('#freq_composta').css('display', 'none');
        $('#freq_composta').remove();
    }
}