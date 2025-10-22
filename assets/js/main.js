document.addEventListener("DOMContentLoaded", () => {
    const burger = document.getElementById("burger-btn");
    const navMenu = document.getElementById("nav-menu");
    const overlay = document.getElementById("nav-overlay");

    if (!burger || !navMenu || !overlay) return;

    const closeMenu = () => {
        burger.classList.remove("active");
        navMenu.classList.remove("open");
        overlay.classList.remove("show");
    };

    burger.addEventListener("click", (e) => {
        e.stopPropagation();
        burger.classList.toggle("active");
        navMenu.classList.toggle("open");
        overlay.classList.toggle("show");
    });

    overlay.addEventListener("click", closeMenu);

    navMenu.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", closeMenu);
    });

    document.addEventListener("click", (e) => {
        if (!navMenu.contains(e.target) && !burger.contains(e.target)) {
            closeMenu();
        }
    });
});

