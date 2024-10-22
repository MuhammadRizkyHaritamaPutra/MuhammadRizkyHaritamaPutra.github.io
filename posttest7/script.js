let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');
let darkModeToggle = document.querySelector('#dark-mode-toggle');
let body = document.body;

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navbar.classList.toggle('active');
}

window.onscroll = () => {
    menu.classList.remove('bx-x');
    navbar.classList.remove('active');
}

darkModeToggle.onclick = () => {
    body.classList.toggle('dark-theme');
    
    if (body.classList.contains('dark-theme')) {
        darkModeToggle.classList.replace('bx-moon', 'bx-sun');
    } else {
        darkModeToggle.classList.replace('bx-sun', 'bx-moon');
    }
}
