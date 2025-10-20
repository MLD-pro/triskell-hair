// assets/app.js

import './bootstrap.js'; /* charge le stimulus qui est un framework inclus par symfony pour plus tard si je veux faire des interactions dynamiques */
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/index.scss'; /* Import du fichier principal SCSS qui regroupe tout mon design  */

// Import de les scripts front-end specifiques
import './js/main.js';
import './js/appointment.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
