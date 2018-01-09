$(function () {
    $('#frequencia').change(function () {
        var freq = document.getElementById('frequencia');
        var freq = document.querySelector("[id='frequencia']");
        var valor = freq.options[freq.selectedIndex].text;

        selecionaFrequencia(valor);

//        var freq = parseInt(document.querySelector("[id='freq_MD']").value);
        var freq = parseInt($("input[id='freq_MD']").val());

        var send = $("input[name='SendPostForm']").val();

        if (isNAN(send)) {
            alert('deu certo!');
        }


//        if (isNaN(freq)) {
//            alert('deu certo!')
//            $('#freq_simples').css('display', 'inline');
//            $('#freq_composta').remove();
//        }
    });
});

function selecionaFrequencia(v) {
    if ((v === 'M/H') || (v === 'D/H')) {
        $('#freq_composta').css('display', 'inline');
        $('#freq_simples').remove();
    } else {
        $('#freq_simples').css('display', 'inline');
        $('#freq_composta').remove();
    }
}