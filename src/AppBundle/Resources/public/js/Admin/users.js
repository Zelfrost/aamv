$(document).ready(function() {
    $('.role select').change(function() {
        window.location.href = Routing.generate('admin_users', {
            role: $(this).val()
        });
    });
});