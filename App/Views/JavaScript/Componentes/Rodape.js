$(document).ready(() => {
    aplicarMascaras();
    
    retornoCadastro();
})

$(document).ajaxSend(function() {
    $("#loading").removeClass('d-none');

    $("#blackScreen").addClass('modal-backdrop');
});

$(document).ajaxComplete(function() {
    $("#loading").addClass('d-none');

    $("#blackScreen").removeClass('modal-backdrop');
});

function aplicarMascaras() {
    $('.moeda').mask('#.##0,00', {reverse: true});
}

function retornoCadastro() {
    const sucesso = $('#sucesso')
    const erro = $('#erro')

    if (sucesso.html() || erro.html()) {
        $('#retornoCadastroModal').modal('toggle')
    }
}

function ativarLoading() {
    $("#loading").removeClass('d-none');

    $("#blackScreen").addClass('modal-backdrop');
}