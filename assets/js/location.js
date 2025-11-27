// assets/js/location.js


document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[name="location_search"]');
    const mapContainer = document.getElementById('map');

    if (!form || !mapContainer) return;

    // Supprime complètement l’icône par défaut Leaflet
    const emptyIcon = L.divIcon({
        className: 'empty-icon',
        html: '',
        iconSize: [0, 0]
    });

    // === Initialisation de la carte Leaflet ===
    if (mapContainer._leaflet_id) {
        mapContainer._leaflet_id = null;
    }

    const map = L.map(mapContainer).setView([47.8667, -3.55], 11); // par défaut : Quimperlé
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker = L.marker([47.8667, -3.55], { icon: emptyIcon })
        .addTo(map)
        .bindPopup("Quimperlé")
        .openPopup();


    // Gestion du formulaire
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

            // popup message
            const popup = document.getElementById('popup-message');
            if (data.message) {
                popup.textContent = data.message.text;
                popup.className = `popup-message ${data.message.type}`;
                popup.style.display = 'block';
                popup.classList.add('show');

                setTimeout(() => {
                    popup.classList.remove('show');
                    popup.style.display = 'none';
                }, 8000);
            }

            // Mise a jour du marqueur sur la carte
            if (data.cityCoords && data.cityCoords.lat && data.cityCoords.lon) {
                const lat = parseFloat(data.cityCoords.lat);
                const lon = parseFloat(data.cityCoords.lon);

                map.setView([lat, lon], 12);
                marker.setLatLng([lat, lon], { icon: emptyIcon });
                marker.bindPopup(`${data.locations[0].city} (${data.locations[0].zipcode})`).openPopup();
            }

        } catch (error) {
            console.error('Erreur lors de la requête AJAX :', error);
        }
    });
});



