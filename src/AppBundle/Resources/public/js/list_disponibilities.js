$(document).ready(function() {
    $('.city select').change(function() {
        window.location.href = Routing.generate('services_disponibilities', {
            city: $(this).val()
        });
    });

    $('.neighborhood select').change(function() {
        window.location.href = Routing.generate('services_disponibilities', {
            city: $('.city select').val(),
            neighborhood: $(this).val(),
        });
    });

    if ($('.city select').val() === "Villeneuve-d'Ascq, France") {
        $('.neighborhood').show();
    } else {
        $('.neighborhood').hide();
    }
});