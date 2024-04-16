## Installer Maatwebsite\Excel

```bash
composer require maatwebsite/excel
```


## Creer une classe pour l'importation

Dans mon cas, j'ai creer une classe TransactionsImport dans le dossier `app/Imports` en utilisant la commande suivante:

```bash
php artisan make:import TransactionsImport
```

Cette classe contient une methode array() qui retourne un tableau contenant les données du fichier excel importé.


## Utilisation de la classe TransactionsImport dans un controller

Dans mon cas, j'ai créé le controller ExcelImportController qui se trouve dans le dossier `app/Http/Controllers`.
Son url est configuré dans le fichier api.php.
Ce controller attend un fichier par requêet POST et utilise la classe TransactionsImport pour importer les données du fichier excel.
Vous pouvez adapter ce controller pour mettre a jour le token des transactions importées.


## Comment tester l'importation

Pour tester l'importation, vous pouvez utiliser Postman ou un autre outil similaire pour envoyer une requête POST avec un fichier excel en pièce jointe.
Voici une image d'illustration de la requête POST envoyée avec Postman:

![Postman](
    illustration-postman.png "Postman"
)