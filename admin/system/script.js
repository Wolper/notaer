$(function () {
//    var valor = document.querySelector("[class='disponibilidade']");
    
//    valor = $(this).closest('tr').find('td[data-valor]').data('valor');
//    alert(valor);

    colorDisponibilidade();
});

function colorDisponibilidade() {
    $('.disponibilidade').after(function () {
    var valor = document.getElementsByClassName('.disponibilidade').value;
    var valor = document.getElementById('disponibilidade').value;
    alert(valor);
        if (valor === undefined) {
            $('.disponibilidade').css('background', 'red');
        } else if (valor === '9:13') {
            $('.disponibilidade').css('background', 'blue');
        }
    });
}