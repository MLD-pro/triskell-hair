// assets/app.js

import './bootstrap.js'; /* charge le stimulus qui est un framework inclus par symfony pour plus tard si je veux faire des interactions dynamiques */
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import '@fortawesome/fontawesome-free/css/all.min.css'; /* Import de Font Awesome pour les icônes des réseaux sociaux */
import '@fortawesome/fontawesome-free/js/all.min.js';

import './styles/index.scss'; /* Import du fichier principal SCSS qui regroupe tout mon design  */

// Import de les scripts front-end specifiques
import './js/main.js';
import './js/appointment.js';
import './js/band.js';
import './js/location.js';

// Import de la librairie pour la map
import 'leaflet/dist/leaflet.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
