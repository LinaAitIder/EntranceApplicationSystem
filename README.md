# Système de Gestion des Concours
Ce projet représente un simple site web créé dans le but d'améliorer mes compétences en PHP. À l'origine, l'idée du projet était un travail pratique proposé dans notre établissement académique, l'ENSA, conçu pour nous permettre de pratiquer ce langage de programmation. Cependant, j'ai choisi de corriger et d'améliorer ce devoir afin qu'il devienne une application complète et fonctionnelle. 

## Objet du projet
Ce site web est conçu pour gérer les inscriptions au concours des écoles. Il offre aux utilisateurs la possibilité de s'inscrire en fournissant toutes les informations nécessaires et de vérifier leur compte. Une fois le compte vérifié, l'utilisateur accède à une page affichant ses informations. À partir de cette page, il peut :
- Modifier ses informations,
- Télécharger le reçu de candidature,
- Se déconnecter,
- Supprimer son compte.
  
Le site gère également plusieurs contraintes, par exemple : un étudiant ayant un niveau Bac+2 ne peut pas postuler pour la 4ᵉ année, parmi d'autres règles spécifiques. De plus, un administrateur a la possibilité de rechercher les candidats par leur nom et de consulter la liste complète des candidats inscrits.

## Fonctionnalités Clés et Concepts Utilisés
### Authentification et gestion des utilisateurs:
  - Création de compte.
  - Authentification des utilisateurs.
  - Vérification des comptes via email .
### Session PHP :
  - Utilisation des sessions pour gerer les connexions des utilisateurs
  - Maintien de l'état de l'utilisateur pendant la navigation.
### Opérations CRUD : 
  - Création, modification, suppression et affichage des données.
  - Application des principes CRUD aux utilisateurs et aux candidatures.
### Structure MVC (Modèle-Vue-Contrôleur) :
  - Organisation du projet pour séparer les responsabilités.
  - Utilisation de contrôleurs pour gérer les actions, modèles pour interagir avec la base de données et vues pour afficher les données.
### Base de données avec MySQLi :
- Connexion sécurisée à une base de données MySQL.
- Requêtes préparées pour éviter les vulnérabilités liées à l'injection SQL.
- Conception et gestion des tables pour stocker les informations des utilisateurs et des candidatures.
### Téléchargement et gestion des fichiers
- Téléchargement des fichiers.
- Génération de documents PDF pour les reçus de candidature.
### Contraintes :
- Mise en place de règles spécifiques (les restrictions pour postuler en fonction du niveau d'études).
- Gestion des erreurs et des exceptions pour assurer une expérience utilisateur fluide.
### Interface utilisateur responsive :
- Utilisation de JavaScript et AJAX pour des fonctionnalités interactives.
- Mise à jour en temps réel des données affichées (résultats de recherche).
## Languages utilisé :
- PHP
- CSS
- Bootstrap
- JS
- SASS
- HTML
- MySql

## ✨ Vidéos Illustrant le projet

https://github.com/user-attachments/assets/0c5e788e-1163-4d3e-910c-f53ec32e25f4

https://github.com/user-attachments/assets/5a60c431-a6b8-4f3d-a4f3-cd72f87dcc6c

