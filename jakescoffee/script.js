const hamburger = document.getElementById('hamburger-menu');
const nav = document.getElementById('nav');

hamburger.addEventListener('click', () => {
    nav.classList.toggle('show');
});