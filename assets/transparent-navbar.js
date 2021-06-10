const triggerNavbar = 350;
const navbar = document.getElementById('navbar');
const titlesNavbar = document.getElementsByClassName('nav-link');
const mediaQuery = window.matchMedia('(min-width: 992px)');

if (mediaQuery.matches) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > triggerNavbar) {
            navbar.classList.add('navbar-invisible');
        } else if (window.scrollY < triggerNavbar) {
            navbar.classList.remove('navbar-invisible');
        }
    });
    navbar.addEventListener('mouseenter', () => {
        if (window.scrollY > triggerNavbar) {
            navbar.classList.remove('navbar-invisible');
        }
    });
    navbar.addEventListener('mouseleave', () => {
        if (window.scrollY > triggerNavbar) {
            navbar.classList.add('navbar-invisible');
        }
    });
}
