$(document).ready(function() {
    $('#create').click(function() {
        $.get(
            Routing.generate('aamv_admin_news_create'),
            function(data) {
                // Create a pop-in with the form
            }
        );
    });

    $('.edit-news').click(function() {
        article = $(this).closest('article');

        if ($(article).data('state') == 'none') {
            $(article).data('state', 'editing');

            $(article).find('span.edit').each(function() {
                name    = $(this).data('name');
                content = $(this).html();

                if (name == 'content') {
                    $(this).html('<textarea rows="6" name="'+name+'">'+content+'</textarea>');
                } else {
                    $(this).html('<input type="text" name="'+name+'" value="'+content+'">');
                }
            });
        } else {
            $(article).data('state', 'none');

            $(article).find('span.edit').each(function() {
                console.log ("tutu");
                name = $(this).data('name');

                if (name == 'content') {
                    content = $(this).find('textarea').val();
                } else {
                    content = $(this).find('input').val();
                }

                $(this).html(content);
            });
        }
    });
});