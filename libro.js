$(document).ready(function() {
    $('#btnAbrirModal').click(function() {
        
        $.get('Resena.html', function(data) {
            const modalHTML = $(data).find('.modal').first();
            $('body').append(modalHTML);
            const modal = new bootstrap.Modal(modalHTML[0]);
            modal.show();
            
            //   cierre del modal
            modalHTML.find('.btn-close, .btn[data-bs-dismiss="modal"]').click(function() {
                modal.hide();
                setTimeout(() => modalHTML.remove(), 500); 
            });
        });
    });
});