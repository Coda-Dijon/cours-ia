# Docker - GitHub Copilot CLI

Image Docker prête à l'emploi pour utiliser GitHub Copilot CLI avec PHP dans un environnement isolé.

## Contenu de l'image

- **Node.js 22** (runtime pour Copilot CLI)
- **PHP CLI** (pour exécuter vos scripts PHP)
- **Git** et **curl** (outils de base)
- **GitHub Copilot CLI** (installé globalement via npm)

## Prérequis

- Docker installé sur votre machine
- Un compte GitHub avec accès à Copilot (gratuit via le [GitHub Student Developer Pack](https://education.github.com/pack))

## Installation

Depuis ce dossier, construisez l'image :

```bash
docker build -t copilot-cli .
```

## Utilisation

### Lancer Copilot CLI avec vos fichiers locaux

Placez-vous dans votre dossier de projet puis lancez :

```bash
docker run -it -v $(pwd):/workspace copilot-cli
```

Vos fichiers locaux seront accessibles dans `/workspace` à l'intérieur du conteneur.

### Authentification

Au premier lancement, utilisez la commande `/login` dans Copilot CLI pour vous authentifier via votre navigateur.

Alternativement, vous pouvez passer un token GitHub (Personal Access Token avec la permission "Copilot Requests") :

```bash
docker run -it -v $(pwd):/workspace -e GH_TOKEN=votre_token copilot-cli
```

### Entrer dans un conteneur déjà lancé

Si le conteneur tourne déjà (par exemple lancé par un autre terminal), repérez son nom puis entrez dedans :

```bash
docker ps                          # repérer le nom du conteneur
docker exec -it <nom_conteneur> bash
```

### Exécuter un script PHP depuis le conteneur

Une fois dans Copilot CLI, vous pouvez demander à Copilot d'exécuter vos fichiers PHP :

```
> Exécute le fichier flashcards.php et explique-moi le résultat
```

Ou sortez de Copilot (`/exit`) et lancez PHP directement :

```bash
docker run -it -v $(pwd):/workspace --entrypoint bash copilot-cli
# puis dans le conteneur :
php /workspace/flashcards.php
```

## Dépannage

- **"copilot: command not found"** : le package npm a peut-être changé de nom. Vérifiez avec `npm search @github/copilot` et ajustez le Dockerfile.
- **Problème d'authentification** : assurez-vous que votre compte GitHub a bien accès à Copilot et que l'organisation ne l'a pas désactivé.
- **Fichiers non visibles** : vérifiez que vous lancez `docker run` depuis le bon dossier, ou utilisez un chemin absolu : `-v /chemin/complet:/workspace`.
