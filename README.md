# Installation des dépendances pour lancer le projet : 
## PHP
  Installer PHP 8.1.3 via ce lien : https://windows.php.net/downloads/releases/php-8.1.30-nts-Win32-vs16-x64.zip
  Le dézipper, puis mettre le dossier a la racine de C:
## Composer
  Installer Composer via ce lien : https://getcomposer.org/Composer-Setup.exe
  Lancer l'installeur, (il devrait trouver tout seul le lien vers PHP 8.1.3),
  Dans l'installation cliquer sur la case à cocher "Ajouter PHP aux Path", ce qui permettera d'utiliser PHP depuis votre terminal.
## Scoop
  L'installation de scoop, permet l'installation de Symfony.
  Pour installer scoop exécutez ces 2 commandes : `Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser` puis celle-ci : `Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression`
## Symfony-cli
  Pour installer Symfony exécutez cette commande : `scoop install symfony-cli`
## Node.js
  Pour installer Node.js téléchargez et installez le, ici : https://nodejs.org/dist/v22.11.0/node-v22.11.0-x64.msi

# Récupération du projet
  Une fois toutes les dépendances installées vous pouvez récuperer le projet.
  Pour ce faire clonez le projet à l'endroit souhaité via cette commande : `git clone https://github.com/batbod349/EcoGrow.git`
  Une fois le projet récuperé, exécutez (dans le projet récuperé) la commande `composer install`
  Puis exécutez la commande `npm install`
**_À chaque fois qu'une dépendances sera ajouté il faudra refaire ces 2 commandes, donc si votre projet ne fonctionne plus, dans le doute, réexécutez ces 2 commandes_**

# Lancement du projet 
  Afin de tester le projet, il faut lancer le serveur symfony en exécutant (dans votre projet) la commande : `symfony serve start`
  Et afin d'avoir le front il faut aussi lancer NPM via cette commande : `npm run dev`
  
