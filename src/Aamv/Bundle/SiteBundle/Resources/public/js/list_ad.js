$(document).ready(function() {
    $('.type select').change(function() {
        window.location.href = Routing.generate('aamv_site_services_ads', {
            type: $(this).val()
        });
    });

    $('.city select').change(function() {
        window.location.href = Routing.generate('aamv_site_services_ads', {
            type: $('.type select').val(),
            city: $(this).val()
        });
    });

    $('.neighborhood select').change(function() {
        window.location.href = Routing.generate('aamv_site_services_ads', {
            type: $('.type select').val(),
            city: $('.city select').val(),
            neighborhood: $(this).val(),
        });
    });

    if ($('.city select').val() === "Villeneuve-d'Ascq") {
        $('.neighborhood').show();
    } else {
        $('.neighborhood').hide();
    }
});