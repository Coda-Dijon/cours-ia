# Docker - Serveur PHP (Apache)

Image Docker pour exécuter le projet FlashCards dans un serveur PHP accessible depuis le navigateur.

## Contenu de l'image

- **PHP 8.3** avec Apache
- **Extensions** : PDO, PDO MySQL, Zip
- **Module Apache** : mod_rewrite activé
- **Listing de fichiers** activé (pratique pour explorer le projet)

## Prérequis

- Docker et Docker Compose installés sur votre machine

## Démarrage rapide

Depuis ce dossier (`Docker-PHP/`) :

```bash
# 1. Construire l'image et démarrer le conteneur
docker compose up -d --build

# 2. Ouvrir dans le navigateur
# → http://localhost:8080
```

C'est tout ! Vos fichiers du dossier `Projet-FlashCards/` sont automatiquement servis par Apache.

## Commandes utiles

```bash
# Voir les logs en temps réel
docker compose logs -f

# Arrêter le conteneur
docker compose down

# Redémarrer après un changement du Dockerfile
docker compose up -d --build

# Entrer dans le conteneur (pour debug)
docker exec -it php-cours-ia bash
```

## Comment ça fonctionne

Le `docker-compose.yml` monte le dossier `../Projet-FlashCards` comme volume dans le conteneur :

```
Projet-FlashCards/  →  /var/www/projet  →  http://localhost:8080
```

Tout fichier `.php` que vous ajoutez ou modifiez dans `Projet-FlashCards/` est immédiatement disponible dans le navigateur **sans redémarrer** le conteneur.

## Structure

```
Docker-PHP/
├── Dockerfile           # Image PHP 8.3 + Apache
├── apache-vhost.conf    # Configuration du VirtualHost
├── docker-compose.yml   # Orchestration avec volume
└── README.md

Projet-FlashCards/       # ← Vos fichiers PHP (montés en volume)
├── index.php            # Page d'accueil
├── phpinfo.php          # Info PHP
├── flashcards.php
├── functions.php
└── data.php
```

## Changer le port

Par défaut le serveur écoute sur le port **8080**. Pour changer, modifiez le mapping dans `docker-compose.yml` :

```yaml
ports:
  - "3000:80"   # → accessible sur http://localhost:3000
```

## Dépannage

- **"Port 8080 already in use"** : changez le port dans `docker-compose.yml` ou arrêtez le service qui utilise ce port.
- **Fichiers non visibles** : vérifiez que vous lancez `docker compose up` depuis le dossier `Docker-PHP/`.
- **Erreur PHP** : consultez les logs avec `docker compose logs -f`.
