$(document).ready(function() {
    $('.fold-panel').click(function() {
        $('.content', this).slideToggle();
    });
});