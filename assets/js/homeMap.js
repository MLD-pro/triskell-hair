import L from "leaflet";
import "leaflet/dist/leaflet.css";

document.addEventListener("DOMContentLoaded", function () {
    const mapContainer = document.getElementById("map");
    if (!mapContainer) return; // Sécurité si la carte n’existe pas sur la page

    const map = L.map(mapContainer).setView([47.8667, -3.55], 11);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    }).addTo(map);

    L.marker([47.8667, -3.55])
        .addTo(map)
        .bindPopup("Quimperlé")
        .openPopup();
});
