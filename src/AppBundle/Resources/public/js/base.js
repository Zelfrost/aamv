// Navbar scroll effect
window.addEventListener('scroll', function() {
    var navbar = document.getElementById('navbar');
    if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 30);
    }
});

// Mobile burger menu
var burger = document.getElementById('navBurger');
var navLinks = document.getElementById('navLinks');

if (burger && navLinks) {
    burger.addEventListener('click', function() {
        var isOpen = navLinks.classList.toggle('open');
        burger.setAttribute('aria-expanded', isOpen);

        // Show/hide mobile auth buttons
        var mobileAuth = navLinks.querySelector('.nav-auth-mobile');
        if (mobileAuth) {
            mobileAuth.style.display = isOpen ? 'flex' : 'none';
        }
    });

    // Close menu when a link is clicked on mobile
    navLinks.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 1050) {
                navLinks.classList.remove('open');
                burger.setAttribute('aria-expanded', false);
                var mobileAuth = navLinks.querySelector('.nav-auth-mobile');
                if (mobileAuth) mobileAuth.style.display = 'none';
            }
        });
    });
}

// Scroll reveal with IntersectionObserver
var revealObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(function(el) {
    revealObserver.observe(el);
});

// jQuery-based features (loaded after jQuery)
$(document).ready(function() {
    // Display-info toggle (used in various inner pages)
    $('.display-info').click(function() {
        $(this).hide();
        $(this).closest('div').find('.button-related').show();
    });
});
