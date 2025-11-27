// Stimulus (framework fourni par Symfony)
import './bootstrap.js';

/*
 * Welcome to your app's main JavaScript file!
 * It will be included via Webpack Encore.
 */

// FontAwesome
/*
import '@fortawesome/fontawesome-free/js/all.min.js';
*/
// Notre SCSS global
import './styles/app.scss';

// Tous les scripts JS du site
import './js/main.js';
import './js/appointment.js';
import './js/band.js';
import './js/location.js';
import './js/homeMap.js';

// Leaflet (pour la map)
import './vendor/leaflet/dist/leaflet.min.css';
import L from "leaflet";

console.log('This log comes from assets/app.js  🎉');

