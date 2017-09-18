$('document').ready(function() {
    $('form.remove').submit(function(e) {
        var that = this;
        e.preventDefault();

        $.confirm({
            text: "Confirmez-vous la suppression ?",
            confirmButton: "Oui",
            cancelButton: "Non",
            confirmButtonClass: "btn-info",
            cancelButtonClass: "btn-danger",
            confirm: function() {
                $(that).unbind('submit').submit();
            }
        });
    });
});