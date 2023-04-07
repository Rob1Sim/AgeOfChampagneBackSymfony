# Age Of Champagne ( AOC ) 
## Robin Simonneau, Erwann Maton, Noa Brébant, Roman Szczepaniak, Dylan Huckel  

## Installation et configuration
Ce projet utlise le framework *Symfony* :
- Pour récupérer les paquets du projets utilisez : 
  ```shell
    composer install
  ```
- Pour lancer le projet utilisez : 
  ```shell
    composer start
  ```
- Pour vérifier que le code est écrit selon le style de codage : PSR-12 utilisez : 
  ```shell
  composer test:cs
    ```
- Pour corriger toute erreur de style de codage utilisez : 
  ```shell
  composer fix:cs
  ```

## Tester le projet
Des tests sont disponibles pour le projet :
- Pour lancer les tests écrits avec codeception et reset la base de donnée de test : 
  ```shell
  composer test:codecept
  ```
- Pour lancer les tests de vérification de style de codage et les tests codeception : 
  ```shell
  composer test
    ```
- Pour reset la base de donnée de tests et ajouter des factices utilsées :
   ```shell
  composer db
    ```

## Base de donnée:
Le fichier de configuration de la base de donnée est `.env.local`
La ligne de configuration de la bd se présente sous cette forme :
```shell
 DATABASE_URL="mysql://user:mdp@ipBD/nomBD?serverVersion=serverVersion
 ```

## Les utilisateurs de connexions factices :
- Admin :
    - login : *admin*
    - password : *test*
- User :
    - login : *UserLambda*
    - password : *test*
- User premium :
    - login : *UserPremium*
    - password : *test*
    
## Docker :
Le site est disponible sur une image docker : 
### Base de donnée :
- MYSQL_USER: breb0007
- MYSQL_PASSWORD: Azerty01
- MYSQL_ROOT_PASSWORD: test
- MYSQL_DATABASE: sae4