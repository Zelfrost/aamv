$(document).ready(function() {
    $('.display-info').click(function() {
        $(this).hide();
        $(this).closest('div').find('.button-related').show();
    });
});