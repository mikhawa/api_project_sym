# Api_project_sym

### Installez Symfony pour Windows

    symfony_windows_amd64.exe
Se trouvant à cette adresse : 

https://symfony.com/download

Ensuite
1. Vérifiez que composer soit bien installé.
2. vérifiez que le raccourci vers PHP 7.* et MySQL 5.* soient bien dans le path des variables globales de Windows.

### Vérification de votre configuration
    symfony check:requirements
Vous verrez si votre environement de travail est prêt et quels services systèmes vous pourrier ajouter pour améliorer les performances.    
### Installation d'un micro service, d'une application console ou une API
    symfony new api_project_sym

L'installation peut prendre un peu de temps mais est minimale, le dosier vendor est presque vide.

On va pouvoir construire un service sur mesure selon les besoins

### On peut déjà démarrer ce service minimal :
    php -S 127.0.0.1:8000 -t public
Et à cette adresse vous trouverez la page d'accueil de votre micro application :

http://127.0.0.1:8000/

Pour quitter le serveur, tapez ctrl+c dans la console.

### Pour voir les services actifs
Tapez simplement dans la console:

    php bin/console
    
### On va ajouter un service important: le Serveur!

    composer require server   
### Pour lancer le Serveur, il suffit maintenant d'écire

    php bin/console server:run
