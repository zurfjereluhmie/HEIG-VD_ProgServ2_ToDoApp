<header>
  <div style="display: flex; justify-content: space-between;">
    <div style="flex: 1;">
	    HEIG-VD
    </div>
    <div style="flex: 1; text-align: center;">
      ProgServ2 <br>
      TodoList Web App 
    </div>
    <div style="flex: 1; text-align: right;">
      7 Décembre 2023
    </div>
  </div>
</header>
# TodoList Web App

## Table des matières

- [Version](#version)
- [Installation](#installation)
- [Configuration](#configuration)
- [Commandes Docker](#commandes-docker)
- [Utilisation](#utilisation)
- [Arborescence du Projet](#arborescence-du-projet)
- [Auteurs](#auteurs)

## Version

Version : 1.0

## Installation

- Installer Docker pour votre OS en suivant ce [lien](https://docs.docker.com/get-docker/).
- Commande pour installer les dépendances Composer :
  - Pour installer Composer : `php composer.phar install`
  - Pour mettre à jour les dépendances : `php composer.phar update`

## Configuration

- Configuration requise :
  - Docker
  - Apache
  - PHP
  - SQLite
  - MailHog

## Commandes Docker

- Démarrer l'application : `sh run_app.sh`
- Arrêter l'application : `docker-compose down`

## Utilisation

- Accès à l'application : [http://localhost:80](http://localhost:80)
- Accès à MailHog : [http://localhost:8025](http://localhost:8025)

## Arborescence du Projet

- Pages du site : racine
- Dossier localisation : pour les traductions
- Dossier component : composants du site
- Dossier controllers : gestion des opérations
- Package ch/comem/todoapp : gestion orientée objet
- Autres : Librairies, etc.

## Auteurs

- Jérémie Zurflüh
- Antoine Uldry
