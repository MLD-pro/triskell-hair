// assets/js/location.js

import L from 'leaflet';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[name="location_search"]');
    const mapContainer = document.getElementById('map');

    if (!form || !mapContainer) return;

    // === Initialisation de la carte Leaflet ===
    const map = L.map(mapContainer).setView([47.8667, -3.55], 11); // par défaut : Quimperlé
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker = L.marker([47.8667, -3.55]).addTo(map).bindPopup("Quimperlé").openPopup();

    // === Gestion du formulaire ===
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const url = form.getAttribute('action') || window.location.href;

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();
            const messageBox = document.getElementById('search-message');

            // Message de réponse
            if (data.message) {
                messageBox.textContent = data.message.text;
                messageBox.className = data.message.type === 'success'
                    ? 'message success'
                    : 'message error';
                messageBox.style.display = 'block';
            }

            // Déplacement du marqueur si on a des coordonnées
            if (data.cityCoords && data.cityCoords.lat && data.cityCoords.lon) {
                const lat = parseFloat(data.cityCoords.lat);
                const lon = parseFloat(data.cityCoords.lon);

                map.setView([lat, lon], 12);
                marker.setLatLng([lat, lon]);
                marker.bindPopup(`${data.locations[0].city} (${data.locations[0].zipcode})`).openPopup();
            }

        } catch (error) {
            console.error('Erreur lors de la requête AJAX :', error);
        }
    });
});


