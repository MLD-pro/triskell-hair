Triskell’Hair est une application web développée avec Symfony. Elle permet aux utilisateurs de demander un rendez-vous, de consulter les prestations, de visualiser les réalisations avant/après, d’accéder à la zone de déplacement et de gérer leur compte utilisateur. Une interface d’administration sécurisée, basée sur EasyAdmin, permet la gestion du contenu du site.

Le projet fonctionne avec PHP 8.4.11, Composer et MySQL. Après avoir cloné le dépôt GitHub, les dépendances PHP sont installées avec la commande « composer install ». Symfony utilise plusieurs fichiers d’environnement versionnés, notamment .env, .env.dev, .env.prod et .env.test. Pour la configuration locale, il est nécessaire de créer un fichier .env.local, non versionné, contenant les informations sensibles comme la connexion MySQL ou la configuration du Mailer. Ce fichier surcharge automatiquement les autres fichiers .env.

La base de données est ensuite initialisée à l’aide des outils Doctrine : création de la base puis exécution des migrations pour générer toutes les tables nécessaires (utilisateurs, rendez-vous, prestations, réalisations avant/après, zones de déplacement et relations associées).

Les assets front-end (SCSS, JavaScript, images…) sont gérés avec Symfony AssetMapper, qui remplace entièrement Webpack Encore. Aucun outil externe comme npm ou Webpack n’est utilisé ni nécessaire. Les fichiers présents dans le dossier « assets » sont automatiquement exposés et transformés si besoin par AssetMapper, sans compilation manuelle.

L’application peut être lancée en local avec la commande « symfony serve » et est accessible par défaut à l’adresse http://localhost:8000/
.
L’architecture du projet suit la structure standard de Symfony : le dossier « src » contient les contrôleurs, entités, formulaires et repositories ; « templates » contient les fichiers Twig ; « assets » contient les fichiers front-end gérés par AssetMapper ; « public » contient les ressources publiques et le point d’entrée de l’application ; et le dossier « config » regroupe la configuration des routes, de la sécurité et des services.

Le déploiement du site a été réalisé sur Hostinger en utilisant une connexion SSH. Une clé SSH a été générée sur l’hébergement puis ajoutée au dépôt GitHub, permettant au serveur d’accéder au code de manière sécurisée. Le projet a ensuite été cloné directement depuis GitHub à l’aide du terminal SSH intégré grâce à la commande « git clone ». Cette méthode assure que la version en ligne est identique à celle du dépôt, sans transfert manuel de fichiers.

Ce projet a été développé dans un cadre pédagogique et représente une mise en œuvre complète d’une application web moderne construite avec Symfony et AssetMapper.
License

This project was developed for educational purposes.
© 2025 Triskell’Hair — All rights reserved.





Triskell’Hair is a web application developed with Symfony. It allows users to request an appointment, browse available services, view before/after results, access the service area, and manage their user account. A secure administration interface, based on EasyAdmin, is used to manage the site’s content.

The project runs with PHP 8.4.11, Composer and MySQL. After cloning the GitHub repository, PHP dependencies are installed using the command “composer install”. Symfony uses several versioned environment files, including .env, .env.dev, .env.prod and .env.test. For local configuration, it is necessary to create a .env.local file, which is not versioned and contains sensitive information such as the MySQL connection or Mailer configuration. This file automatically overrides the other .env files.

The database is then initialized using Doctrine tools: database creation followed by executing migrations to generate all the necessary tables (users, appointments, services, before/after achievements, service areas and associated relations).

Front-end assets (SCSS, JavaScript, images, etc.) are managed with Symfony AssetMapper, which completely replaces Webpack Encore. No external tools such as npm or Webpack are required. Files stored in the “assets” directory are automatically exposed and transformed by AssetMapper if needed, without manual compilation.

The application can be launched locally using the command “symfony serve” and is accessible by default at the address http://localhost:8000/
. The project structure follows the standard Symfony organization: the “src” folder contains controllers, entities, forms and repositories; the “templates” folder contains Twig files; the “assets” folder contains front-end files managed by AssetMapper; the “public” folder contains public resources and the application entry point; and the “config” folder contains the routes, security and services configuration.

The deployment of the site was carried out on Hostinger using an SSH connection. An SSH key was generated on the hosting platform and added to the GitHub repository, allowing the server to securely access the source code. The project was then cloned directly from GitHub using the integrated SSH terminal with the command “git clone”. This method ensures that the version online is identical to the one in the repository, without any manual file transfer.

This project was developed in an educational context and represents a complete implementation of a modern web application built with Symfony and AssetMapper.

This project was developed for educational purposes. © 2025 Triskell’Hair — All rights reserved.
