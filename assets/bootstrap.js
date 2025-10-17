// assets/bootstrap.js

// Initialisation propre sans Stimulus Bundle
import { Application } from "@hotwired/stimulus";

const app = Application.start();
console.log("Stimulus actif sans @symfony/stimulus-bundle (version npm).");

// Ajouter les contrôleurs ici plus tard, ex. :
// app.register("example", ExampleController);

