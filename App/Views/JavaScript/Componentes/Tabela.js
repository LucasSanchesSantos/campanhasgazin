$(document).ready(async () => {
    await $('table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
        },
        dom: '<"d-flex justify-content-between align-items-center"fB>rt<"d-flex justify-content-between align-items-center"ilp>',
        buttons: [
            {
                extend:    'excel',
                text:      '<i class="bi bi-file-earmark-spreadsheet-fill"></i>  Excel',
                titleAttr: 'Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdf',
                text:      '<i class="bi bi-filetype-pdf"></i> PDF',
                titleAttr: 'Pdf',
                className: 'btn btn-pdf'
            }
        ]
    });
})

var cards = document.querySelectorAll('.custom-card');

cards.forEach(function(card, index) {
    card.addEventListener('click', function() {
        var collapseId = "#collapse" + index;
        var collapse = document.querySelector(collapseId);
        if (collapse) {
            $(collapse).collapse('toggle');
        }
    });
});


$(document).ready(function(){
    $('#telefone').mask('(00) 0 0000-0000', {placeholder: " "});
});
