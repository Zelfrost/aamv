$('document').ready(function() {
    $('form.remove').submit(function(e) {
        var that = this;
        e.preventDefault();

        if (window.confirm("Confirmez-vous la suppression ?")) {
            $(that).unbind('submit').submit();
        }
    });
});
