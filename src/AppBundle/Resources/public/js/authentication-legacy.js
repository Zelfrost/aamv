$(document).ready(function() {
    var manageAccountUrl = $('#manage-account-url').data('url');

    $('<div></div>').appendTo('body')
        .html('Votre compte a été automatiquement importé depuis l\'ancien site.\n\
            Il vous est donc conseillé de vérifier que toutes vos données sont exactes.\n\
            Souhaitez-vous vous rendre sur votre page de profil afin de vérifier vos données?')
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
                        window.location.href = manageAccountUrl;
                    }
                },
                {
                    'text': 'Non, pas maintenant',
                    'click': function() {
                        $(this).dialog('close');
                    }
                }
            ]
        })
    ;
});
