$(document).ready(function() {
    var urlTemplate = $('#ads').data('url');

    $('.city select').change(function() {
        window.location.href = urlTemplate
            .replace('__CITY__', encodeURIComponent($(this).val()))
            .replace('__NEIGH__', 'none');
    });

    $('.neighborhood select').change(function() {
        window.location.href = urlTemplate
            .replace('__CITY__', encodeURIComponent($('.city select').val()))
            .replace('__NEIGH__', encodeURIComponent($(this).val()));
    });

    if ($('.city select').val() === "Villeneuve-d'Ascq, France") {
        $('.neighborhood').show();
    } else {
        $('.neighborhood').hide();
    }
});
