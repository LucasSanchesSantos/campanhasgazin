document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var deleteUrl = this.getAttribute('href');
            $('#confirmacaoExclusaoModal').modal('show');
            document.getElementById('confirmarExclusao').setAttribute('href', deleteUrl);
        });
    });
});