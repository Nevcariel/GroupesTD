# Groupes TD
## Introduction

Cette application a pour but de faciliter la fomration des groupes TD en DUT informatique pour le département informatique de l'IUT d'Amiens.

## Prérequis


- php 7.2 : 

```
sudo apt-get install php7.2
```

- php curl :

```
sudo apt-get install php7.2-curl
```

- Composer :

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=bin --filename=composer
php -r "unlink('composer-setup.php');"
```

- SQLite ou MySQL :

```
sudo apt-get install sqlite3
```

ou

```
sudo apt install mysql-server
```

## Configuration

- L'application est paramétrée par défaut pour utiliser SQLite. Pour utiliser MySQL :

Remplacer la totalité du contenu du fichier ./config/packages/doctrine.yaml par :

```
parameters:
    # Adds a fallback DATABASE_URL if the env var is not set.
    # This allows you to run cache:warmup even if your
    # environment variables are not available yet.
    # You should not need to change this value.
    env(DATABASE_URL): ''

doctrine:
    dbal:
        # configure these for your database server
        driver: 'pdo_mysql'
        server_version: '5.7'
        charset: utf8mb4
        default_table_options:
            charset: utf8mb4
            collate: utf8mb4_unicode_ci

        url: '%env(resolve:DATABASE_URL)%'
    orm:
        auto_generate_proxy_classes: '%kernel.debug%'
        naming_strategy: doctrine.orm.naming_strategy.underscore
        auto_mapping: true
        mappings:
            App:
                is_bundle: false
                type: annotation
                dir: '%kernel.project_dir%/src/Entity'
                prefix: 'App\Entity'
                alias: App
```

Remplacer la totalité du contenu du fichier ./.env par :

```
# This file is a "template" of which env vars need to be defined for your application
# Copy this file to .env file for development, create environment variables when deploying to production
# https://symfony.com/doc/current/best_practices/configuration.html#infrastructure-related-configuration

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=0c94212559cd3d8678c06b4b876a12f4
#TRUSTED_PROXIES=127.0.0.1,127.0.0.2
#TRUSTED_HOSTS=localhost,example.com
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
# Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
# Configure your db driver and server_version in config/packages/doctrine.yaml
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/groupetd
###< doctrine/doctrine-bundle ###
```
- Pour utiliser le panneau d'administration, il faut renseigner votre login pour le CAS dans le fichier ./config/packages/security.yaml

```
security:
    # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
    #providers:
    #    in_memory: { memory: ~ }
    providers:
        chain_providers:
            chain:
                providers: [in_memory, bdd_etudiant]
        in_memory:
            memory:
                users:
                    g21707397:
                        roles: 'ROLE_ADMIN'
                    [votre login]:
                        roles: 'ROLE_ADMIN'
```

- L'adresse par défaut du site est http://127.0.0.1:8000 en cas de changement il faut remplacer cette adresse par la nouvelle dans le fichier ./config/packages/l3cas.yaml

```
parameters:
  cas_login_target: 'http://127.0.0.1:8000'     //ici
  cas_host: 'cas.u-picardie.fr'

l3_cas:
  host: 'cas.u-picardie.fr'
  path: ~
  port: 443
  ca: false
  handleLogoutRequest: true
  casLogoutTarget: 'http://127.0.0.1:8000'      //et ici
  force: true
```

## Instalation


- Télécharger l'archive et la dézipper

ou

- Se positionner dans le répertoire de destination et utiliser la commande : 

```
git clone https://github.com/Nevcariel/GroupesTD.git
```

- Se positionner dans le répertoire de l'application

- Lancer les commandes suivantes :

```
composer install
php bin/console cache:clear
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
- Pour démarrer l'application :

```
php bin/console server:run
```

- Par défaut l'application est accessible à l'adresse http://127.0.0.1:8000

- L'interface d'administration est accessible via http://127.0.0.1:8000/admin


## Utilisation

[Guide d'utilisation de l'application](./docs/guide_utilisation.pdf)


## Auteur

Romain Guilcher.


