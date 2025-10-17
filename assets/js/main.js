
document.addEventListener("DOMContentLoaded", () => {
    const burger = document.getElementById("burger-btn");
    const menu = document.getElementById("nav-menu");

    burger.addEventListener("click", () => {
        menu.classList.toggle("open");
    });
});
