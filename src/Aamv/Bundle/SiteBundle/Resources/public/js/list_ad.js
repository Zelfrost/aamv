$(document).ready(function() {
    $('.adsCity select').change(function() {
        window.location.href = Routing.generate('aamv_site_services_ads', {
            type: $(this).data('type'),
            city: $('option:selected', this).val()
        });
    })
});