// assets/js/band.js

document.addEventListener('DOMContentLoaded', () => {
    const strip = document.getElementById('scrolling-strip');
    if (!strip) return;

    // 1) Dupliquer le contenu jusqu'à dépasser largement la largeur de l'écran
    const unitHTML = strip.innerHTML;
    const targetWidth = window.innerWidth * 3;      // marge confortable
    while (strip.scrollWidth < targetWidth) {
        strip.insertAdjacentHTML('beforeend', unitHTML);
    }

    // 2) Défilement continu + recyclage des éléments au fil de l'eau
    let x = 0;
    const pxPerFrame = 0.8;                         // vitesse (ajuste si besoin)

    const getGap = () => {
        const g = getComputedStyle(strip).gap;
        return g ? parseFloat(g) : 0;
    };

    function tick() {
        x -= pxPerFrame;

        // Quand le premier élément est complètement sorti à gauche,
        // on le pousse en fin de liste et on recale 'x' => pas de "trou".
        const first = strip.firstElementChild;
        if (first) {
            const firstWidth = first.getBoundingClientRect().width + getGap();
            if (-x >= firstWidth) {
                strip.appendChild(first);
                x += firstWidth;
            }
        }

        strip.style.transform = `translateX(${x}px)`;
        requestAnimationFrame(tick);
    }

    requestAnimationFrame(tick);
});

