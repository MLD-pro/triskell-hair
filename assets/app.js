// assets/app.js

import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css'; // tu pourras remplacer par './styles/app.scss' plus tard

// Import de les scripts front
import './js/main.js';
import './js/appointment.js';

// Import d’images (pour que Webpack les inclue dans le build)
import './images/logo_h.png';
import './images/header-bg.png';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
