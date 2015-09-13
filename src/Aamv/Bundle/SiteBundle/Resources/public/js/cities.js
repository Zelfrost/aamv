$(document).ready(function() {
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
});