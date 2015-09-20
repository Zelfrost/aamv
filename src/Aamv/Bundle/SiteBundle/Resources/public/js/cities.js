$(document).ready(function() {
    if ($('.select2').val() !== "Villeneuve-d'Ascq") {
        $('#fos_user_registration_form_neighborhood').closest('div').hide();
    }

    $('.select2').select2({
        language: 'fr',
        ajax: {
            url: function(params) {
                return Routing.generate('aamv_site_api_cities', {'name': params.term})
            },
            dataType: 'json',
            processResults: function (data, page) {
                return {
                    results: data
                };
            }
        },
        minimumInputLength: 3
    });

    $('.select2').change(function() {
        if ($(this).val() === "Villeneuve-d'Ascq") {
            $('#fos_user_registration_form_neighborhood').closest('div').show();
        } else {
            $('#fos_user_registration_form_neighborhood').closest('div').hide();
            $('#fos_user_registration_form_neighborhood').val(null);
        }
    });
});