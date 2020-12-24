# API Produits.

Produits est une API de gestion de stock, créer un but éducatif, qui permet d'abord de renseigner les stocks (entre autres la nature et la quantité). Puis de les administrer.

### Configuration requise

Ce qui est requis pour commencer avec API Produits

- Apache minimum 2.4.35
- PHP minimum 7.3.1
- MySQL minimum 5.7.24

### Procédure d’installation 

D'abord Avoir git d'installer sur son ordinateur.
En suite entrez la commande sur votre terminal.
```
git clone https://github.com/Magikmagnum/api_test.git
```


## Démarrage

Situez vous dans le répertoire de l'API en tapant la commande si dessous 
```
cd api_test
```
Installer toutes les dépendances en tapant la commande  si dessous
```
composer install
```
Aller dans le fichier .env à la racine du repertoire de API Produits. A la ligne "DATABASE_URL=mysql:" modifier le db_user, le db_passeword et le db_name. selon les parametres de votre base de donnée.
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
Taper la commande  si dessous, pour initializer base de données.
```
php bin/console doctrine:database:create
```
Taper la commande  si dessous, pour créer automatiquement toutes les tables de base de données nécessaires.
```
php bin/console doctrine:schema:update --force
```
## Fabriqué avec

Entrez les programmes/logiciels/ressources que vous avez utilisé pour développer votre projet

_exemples :_
* [Materialize.css](http://materializecss.com) - Framework CSS (front-end)
* [Atom](https://atom.io/) - Editeur de textes

## Contributing

Si vous souhaitez contribuer, lisez le fichier [CONTRIBUTING.md](https://example.org) pour savoir comment le faire.

## Versions
Listez les versions ici 
_exemple :_
**Dernière version stable :** 1.0
Liste des versions : [Cliquer pour afficher](https://github.com/Magikmagnum/api_test/tags)
_(pour le lien mettez simplement l'URL de votre projets suivi de ``/tags``)_

## Auteurs
Listez le(s) auteur(s) du projet ici !
* **Eric Gansa Diambote** _alias_ [@Magikmagnum](https://github.com/Magikmagnum)


## License

Ce projet est sous licence ``licence du MIT``
