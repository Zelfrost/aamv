$(document).ready(function() {
    $('.display-info').click(function() {
        $(this).hide();
        $(this).closest('div').find('.button-related').show();
    });

    // Hamburger toggle (mobile)
    $('#nav-toggle').on('click', function() {
        var $menu = $('#nav-main-menu');
        var isOpen = $menu.hasClass('open');
        $menu.toggleClass('open');
        $(this).attr('aria-expanded', !isOpen);
    });

    // Submenu toggle on touch/click (mobile only)
    $('nav li.has-submenu').on('click', function(e) {
        if ($(window).width() >= 768) return;
        e.stopPropagation();
        var $submenu = $(this).children('div');
        var wasOpen = $(this).hasClass('submenu-open');
        // Close all others
        $('nav li.has-submenu').removeClass('submenu-open').children('div').slideUp(150);
        if (!wasOpen) {
            $(this).addClass('submenu-open');
            $submenu.slideDown(150);
        }
    });

    // Prevent closing when clicking inside submenu
    $('nav li.has-submenu div').on('click', function(e) {
        e.stopPropagation();
    });

    // Close menu when a link is clicked on mobile
    $('#nav-main-menu a').on('click', function() {
        if ($(window).width() < 768) {
            $('#nav-main-menu').removeClass('open');
            $('#nav-toggle').attr('aria-expanded', false);
        }
    });
});
