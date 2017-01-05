$(document).ready(function() {
    $('<div></div>').appendTo('body')
        .html('Votre ')
        .dialog({
            modal: true,
            title: 'Bienvenue sur le nouveau site de l\'AAMV !',
            zIndex: 10000,
            autoOpen: true,
            width: 500,
            resizable: false,
            buttons: [
                {
                    'text': 'Oui, je souhaite vérifier',
                    'class': 'confirm',
                    'click': function() {
                        window.location.href = Routing.generate('manage_account');
                    }
                },
                {
                    'text': 'Pas maintenant',
                    'click': function() {
                        $(this).dialog('close');
                    }
                }
            ]
        });
});