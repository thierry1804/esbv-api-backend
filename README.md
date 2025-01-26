# Eshop By Valsue - API Backend

API backend pour l'application de vente en ligne Eshop By Valsue.

## Description

Ce projet contient l'ensemble des APIs nécessaires pour faire fonctionner l'application Eshop By Valsue. Il gère toutes les opérations backend comme la gestion des produits, des commandes, des utilisateurs et des transactions.

## Prérequis

- PHP >= 8.1
- Composer
- Symfony CLI
- MySQL/MariaDB
- Extensions PHP requises :
  - ctype
  - iconv
  - session
  - tokenizer
  - xml

## Installation

1. Cloner le repository
```bash
git clone [url-du-repository]
```

2. Installer les dépendances
```bash
composer install
```

3. Configurer les variables d'environnement
```bash
cp .env .env.local
```

4. Configurer la base de données dans le fichier .env.local

5. Créer la base de données et exécuter les migrations
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. Démarrer le serveur de développement
```bash
symfony serve
```

## Documentation

Pour plus de détails techniques sur l'API, consultez le fichier [bookdev.md](./bookdev.md).

## Contribution

Pour contribuer au projet, veuillez suivre les conventions de code et le processus de pull request décrits dans la documentation technique.

## Licence

Tous droits réservés - Eshop By Valsue 