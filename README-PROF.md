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
- [Documentation](#documentation)
- [Auteurs](#auteurs)

## Version

Version : 1.0

## Installations Requises

- Installer Docker pour votre OS en suivant ce [lien](https://docs.docker.com/get-docker/).
- Commande pour installer les dépendances Composer : `composer install`

## Configuration

- Configuration **nécessaire** sur le poste de travail :

  - Docker
  - PHP CLI
  - Composer CLI

- Configuration de l'application :

  - Docker
  - Apache
  - PHP
  - SQLite
  - MailHog

## Commandes Docker

- Démarrer l'application :
  - `sh run_app.sh` ou `bash run_app.sh` pour Windows
  - ou
  - `docker-compose up -d`
- Arrêter l'application : `docker-compose down`

## Utilisation

- Accès à l'application : [http://localhost:80](http://localhost:80)
- Accès à MailHog : [http://localhost:8025](http://localhost:8025)

- Compte utilisateur d'exemple déjà créé :
  - Email : `jphess@gmail.com`
  - Mot de passe : `1234`

## Arborescence du Projet

- Pages du site : `public/`
- Dossier de configuration (DB et PHP) : `config/`
- Dossier `public/local/` : pour les traductions
- Dossier `public/component/` : composants du site
- Dossier `controllers/` : gestion des opérations
- Dossier `app/` :
  - Package `ch/comem/todoapp` : gestion orientée objet
- Documentation (automatique) : `docs/` _Générée avec phpDocumentor_
- Autres : Librairies, etc.

## Documentation

La documentation est disponible dans le dossier `docs/` et peut être générée avec la commande `sh generate_docs.sh` ou `bash generate_docs.sh`.

Pour lire la documentation, ouvrez le fichier `docs/index.html` dans votre navigateur.

## Auteurs

- Jérémie Zurflüh
- Antoine Uldry
