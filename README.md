# API Produits.

API Produits est une API de gestion de stock, créer à but éducatif dans le cadre d'une formation , qui permet d'abord de renseigner les stocks (entre autres la nature et la quantité). Puis de les administrer.

## Configuration requise

Ce qui est requis pour commencer avec API Produits

- Apache minimum 2.4.35
- PHP minimum 7.3.1
- MySQL minimum 5.7.24
- Git minimum 2.28.0

## Procédure d’installation 

D'abord, Allez dans le répertoire vous souhaitez cloner le dépôt et entrez la commande si dessous sur votre terminal.
```
git clone https://github.com/Magikmagnum/api_test.git
```
Ensuite, situez vous dans le répertoire racine de l'API en tapant la commande si dessous 
```
cd api_test
```
Puis, installer toutes les dépendances en tapant la commande  si dessous
```
composer install
```
Apres, aller dans le fichier .env à la racine du repertoire de API Produits. A la ligne 29 "DATABASE_URL=mysql:" modifier le db_user, le db_passeword et le db_name. selon les parametres de votre base de donnée.
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
Par la suite, taper la commande  si dessous, pour initializer base de données.
```
php bin/console doctrine:database:create
```
Enfin, taper la commande  si dessous, pour créer automatiquement toutes les tables de base de données nécessaires.
```
php bin/console doctrine:schema:update --force
```
## Lancer le serveur
Apres l'activation de votre serveur de base de données, taper la commande si dessous, pour lancer le serveur interne de PHP
```
php -S 127.0.0.1:8000 -t public
```
## Lien de la documentation
https://github.com/Magikmagnum/api_test/blob/master/Documentation.pdf

## Auteurs

* **Eric Gansa Diambote** _alias_ [@Magikmagnum](https://github.com/Magikmagnum)

## License
Ce projet est sous licence ``licence du MIT``
Pour tout besoin d'aide, d'assistance ou de report de bug prière de contacter l'équipe technique à l'adresse suivante : ericgansa01@gmail.com
