$('document').ready(function() {
    $('form.remove').submit(function(e) {
        e.preventDefault();

        $.confirm({
            text: "Confirmez-vous la suppression ?",
            confirmButton: "Oui",
            cancelButton: "Non",
            confirmButtonClass: "btn-info",
            cancelButtonClass: "btn-danger",
            confirm: function() {
                $('form.remove').unbind('submit').submit();
            }
        });
    });
});