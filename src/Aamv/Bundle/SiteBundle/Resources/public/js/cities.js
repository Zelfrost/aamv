$(document).ready(function() {
    var city = $('#aamv_user_profile_city').data('value');

    $('.select2').select2({
        language: 'fr',
        ajax: {
            url: function(params) {
                return Routing.generate('aamv_site_api_cities', {'name': params.term})
            },
            dataType: 'json',
            processResults: function (data, page) {
                console.log(data);
                return {
                    results: data
                };
            }
        },
        minimumInputLength: 3
    });

    $('#aamv_user_profile_city').empty().append('<option selected value="'+city+'">'+city+'</option>').val(city).trigger('change');

    if ($('.select2').val() !== "Villeneuve-d'Ascq") {
        $('.form-control.neighborhood').closest('div').hide();
        $('.form-control.neighborhood').prop('required', false);
    }

    $('.select2').change(function() {
        if ($(this).val() === "Villeneuve-d'Ascq") {
            $('.form-control.neighborhood').closest('div').show();
            $('.form-control.neighborhood').prop('required', true);
        } else {
            $('.form-control.neighborhood').closest('div').hide();
            $('.form-control.neighborhood').val(null);
            $('.form-control.neighborhood').prop('required', false);
        }
    });
});
