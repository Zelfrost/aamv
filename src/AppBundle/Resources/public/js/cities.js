$(document).ready(function() {
    var city = $('form.city').data('value');

    $('.select2').select2({
        language: 'fr',
        ajax: {
            url: function(params) {
                return Routing.generate('api_cities', {'name': params.term})
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

    $('form.city').empty().append('<option selected value="'+city+'">'+city+'</option>').val(city).trigger('change');

    if ($('.select2').val() !== "Villeneuve-d'Ascq, France") {
        $('.form-control.neighborhood').closest('div').hide();
        $('.form-control.neighborhood').val(null);
        $('.form-control.neighborhood').prop('required', false);
    }

    $('.select2').change(function() {
        if ($(this).val() === "Villeneuve-d'Ascq, France") {
            $('.form-control.neighborhood').closest('div').show();
            $('.form-control.neighborhood').prop('required', true);
        } else {
            $('.form-control.neighborhood').closest('div').hide();
            $('.form-control.neighborhood').val(null);
            $('.form-control.neighborhood').prop('required', false);
        }
    });
});
