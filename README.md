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
### Pour lancer le Serveur, il suffit maintenant d'écire :

    php bin/console server:run
Et utiliser ctrl+c pour arrêter le serveur, vous remarquez que vous voyez les logs dans pages appelées.
## Routing par défaut : 
#### config/routes.yaml
Remplacez : 

    #index:
    #    path: /
    #    controller: App\Controller\DefaultController::index
Par (avec ctrl+/)

    index:
        path: /
        controller: App\Controller\DefaultController::index
Attention les fichiers yaml sont très stricts, ils servent à la configuration des serveurs, les tabulations sont en fait 4 espaces!

Puis changeons le chemin vers un contrôleur que nous allons créer :
    
    index:
        path: /
        controller: App\Controller\ArticleController::accueil
### Création manuelle d'un contrôleur
Créons une class ArticleController dans src/Controller
       
       <?php
       namespace App\Controller;
       
       
       class ArticleController
       {
       
       }        
Créons ensuite la méthode "accueil" et appelons avec use le générateur de réponse 

    <?php
    
    // nom de l'espace de travail
    namespace App\Controller;
    
    // dépendance pour envoyer une réponse :
    use Symfony\Component\HttpFoundation\Response;
    
    // class
    class ArticleController
    {
        // méthode d'accueil
        public function accueil()
        {
            return new Response('mon premier texte envoyé... bon ok Hello World');
        }
    }
## Le routing avancé
### Les annotations
#### Dans config/routes.yaml :
recommentez les lignes

    #index:
    #    path: /
    #    controller: App\Controller\ArticleController::accueil

### Installation des annotations

    composer require annotations
    
### Utilisation de celles-ci 

    // dépendance pour envoyer une réponse :
    use Symfony\Component\HttpFoundation\Response;
    // dépendance pour les annotations
    use Symfony\Component\Routing\Annotation\Route;
    
    // class
    class ArticleController
    {
        // méthode d'accueil avec annotations
        /**
         * @Route("/")
         */
        public function accueil()
        {
            return new Response('mon premier texte envoyé... bon ok Hello World');
        }
    }   
#### Créons une autre route en annotations : 
Avec cette URL : 
http://127.0.0.1:8000/news/belle-page

Dans notre contôleur:

    /**
     * @Route("/")
     */
    public function accueil()
    {
        return new Response('mon premier texte envoyé... bon ok Hello World');
    }
    
    /**
     * @Route("/news/belle-page")
     */
    public function voir()
    {
        return new Response('Voici l\'URL d\'un article!');
    }   
    
### Pour débuguer vos routes :

     php bin/console debug:router
un nom par défaut a été créé: espaceDeTravail_class_methode    

### On veut rendre ces routes dynamiques :

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf(
            'Le nom de la page sera: "%s"',
            $slug
        ));
    } 
### Installons le checker de sécurité

    composer require sec-checker --dev
    
sec-checker n'existe pas vraiment, c'est FLEX, intégré à Symfony, qui va chercher les dépendances proches de celles demandées!

Il installe réellement sensiolabs/security-checker !

Pour tester la sécurité de nos dépendances :

    php bin/console security:check
    
### Installation de Twig

    composer require twig
