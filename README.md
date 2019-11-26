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
### Pour utiliser Twig
Importez le contrôleur Abstrait dans votre contrôleur

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
Et utilisez-le en étendant votre classe actuelle avec extend

    class ArticleController extends AbstractController   
Vous pouvez ensuite appeler la vue par défaut du dossier templates nommé base.html.twig :

     // nom de l'espace de travail
     namespace App\Controller;
     
     // dépendance pour utiliser Twig et les autres dépendances liées au contrôleur:
     use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
     // dépendance pour envoyer une réponse :
     use Symfony\Component\HttpFoundation\Response;
     // dépendance pour les annotations
     use Symfony\Component\Routing\Annotation\Route;
     
     // class
     class ArticleController extends AbstractController
     {
         // méthode d'accueil avec annotations
         /**
          * @Route("/")
          */
         public function accueil()
         {
             return new Response('mon premier texte envoyé... bon ok Hello World');
         }
         
     
         /**
          * @Route("/news/{slug}")
          */
         public function show($slug)
         {
             return $this->render('base.html.twig',[
                 "texte"=>(sprintf(
                 'Le nom de la page sera: "%s"',
                 $slug))]
             );
         }
     }
Vous devez ensuite placer la variable "texte" dans base.html.twig 

        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>{% block title %}Welcome!{% endblock %}</title>
                {% block stylesheets %}{% endblock %}
            </head>
            <body>
                {% block body %}<h3>{{ texte }}</h3>{% endblock %}
                {% block javascripts %}{% endblock %}
            </body>
        </html>
### Gestion de Twig
Elle est la même que vue précédement: 
#### Pour étendre la vue :

    {% extends 'base.html.twig' %}
#### Les filtres de base :

    {{ name|upper|lower|upper|lower|upper }}
#### Les boucles en twig

    {% for comment in comments %}
        <li>{{ comment }}</li>
    {% endfor %}    
### Installation du profiler

    composer require profiler --dev    
Cette barre est très utile en mode développement !    

#### dump dans le contrôleur

    public function show($slug)
    {
        dump($slug, $this);
        return $this->render('news/news.html.twig',[
            "texte"=>(sprintf(
            'Le nom de la page sera: "%s"',
            $slug))]
        );
    }
#### dump dans Twig

    {% block body %}<h3>{{ texte }}</h3>
    {{ dump(texte) }}{% endblock %}        
    
### Installation d'outils de débogage

    composer require debug --dev  
Le dump apparaît maintenant dans la barre du profiler
#### On peut séparer les packs !
Avant dans composer.json:

    "require-dev": {
            "sensiolabs/security-checker": "^6.0",
            "symfony/debug-pack": "^1.0",
            "symfony/profiler-pack": "^1.0"
        },
On décide de récupérer individuellement les librairies qui la compose :
        
    composer unpack debug    
On obtient les librairies qui compose le pack, on peut ainsi ne garder que celles qu'on souhaite!

    "require-dev": {
            "easycorp/easy-log-handler": "^1.0.7",
            "sensiolabs/security-checker": "^6.0",
            "symfony/debug-bundle": "*",
            "symfony/monolog-bundle": "^3.0",
            "symfony/profiler-pack": "*",
            "symfony/var-dumper": "*"
        },
### Récupérez le fichier base.html.twig
Dans l'archives datas/code-symfony.zip dans start/tutorial/templates/
et remplacez l'existant      

### Pour vider le cache
Utilisez la commande:

    php bin/console cache:clear
    
### Récupérez les dossiers images, fonts et css
Depuis l'archive (start/tutorial/templates/) et mettez les dans le répertoire public      

#### chargement des fichiers .css depuis base.html.twig  

en cherchant simplement dans public

    {% block stylesheets %}
     <link rel="stylesheet" href="/css/font-awesome.css">
     <link rel="stylesheet" href="/css/styles.css">
     
### chargement d'asset, pour la gestion des fichiers front-end

    composer require asset     
    
#### Chargement dynamique grâce à asset()
    {% block stylesheets %}
        <link rel="stylesheet" 
        href="{{ asset('css/font-awesome.css') }}">
        <link rel="stylesheet" 
        href="{{ asset('css/styles.css') }}">
    Ligne 35:  <img class="nav-profile-img rounded-circle" 
    src="{{ asset('images/astronaut-profile.png') }}">  
    
### Transformez article.html.twig 

en news.html.twig

### changez dans le contrôleur:
#####ArticleController.php

    public function show($slug)
        {
            dump($slug, $this);
            $comments = [
                'I ate a normal rock once. It did NOT taste like bacon!',
                'Woohoo! I\'m going on an all-asteroid diet!',
                'I like bacon too! Buy some from my site! bakinsomebacon.com',
            ];
            return $this->render('news/news.html.twig',[
                    'comments' => $comments,
                    'title' => ucwords(str_replace('-', ' ', $slug))]
            );
        }
### Path en Twig
Permet d'atteindre une route dans un lien Twig

    {{ path('app_article_accueil') }}
### Renommer une route en annotation

    /**
     * @Route("/", name="accueil")
     */   
#### Déplacement de homepage.html.twig     
Dans templates/news/ depuis 
    
    datas\code-symfony\start\tutorial\templates\homepage.html.twig

#### changement de ArticleController.php

    public function accueil()
    {
        return $this->render('news/homepage.html.twig');
    }
### Lien avec variable GET
Dans homepage.html.twig (+-Ligne 22) :

    <a href="{{ path('articles', 
    {slug: 'why-asteroids-taste-like-bacon'}) }}">         
Dans ArticleController.php :

     /**
      * @Route("/news/{slug}", name="articles")
      */
      public function show($slug)
      {  
      ...

### Javascript / AJAX
Utilisation de Javascript avec Jquery
#### Création de article_show.js
Dans public/js/ avec le code minimal :

       $(document).ready(function() {
       
       });
#### Ajout du titre
Dans news.html.twig avant le block body :

    {% block title %}Read: {{ title }}{% endblock %}
#### Création du span pour l'AJAX
Dans news.html.twig  (+- ligne 17) on entoure le 5 par le span : 

    <span class="js-like-article-count">5</span>
Et on rajoute  js-like-article à la classe entourant le coeur (même ligne)

    <a href="#" class="fa fa-heart-o like-article  js-like-article"></a>
        
#### Ajout dans article_show.js

    $(document).ready(function() {
        $('.js-like-article').on('click', function(e) {
            e.preventDefault();
    
            var $link = $(e.currentTarget);
            $link.toggleClass('fa-heart-o').toggleClass('fa-heart');
    
            $('.js-like-article-count').html('TEST');
        });
    });
#### Pour ajouter le script que sur la page news.html.twig
En dehors de tout autre block :

    {% block javascripts %}
        {{ parent() }}
        <script src="{{ asset('js/article_show.js') }}"></script>
    {% endblock %}    
        
Voila, si vous cliquez sur le coeur "TEST" remplace le 5                 
#### Création de la méthode pour le coeur
Dans ArticleController.php

    // dépendance pour utiliser json :
    use Symfony\Component\HttpFoundation\JsonResponse;
    
    ...
    
    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug)
    {
        // TODO - actually heart/unheart the article!
        return new JsonResponse(['hearts' => random_int(5, 100)]);
    }   
#### Mise en place du lien
Dans news.html.twig (+- ligne 17):

    <span class="pl-2 article-details"> 
    <span class="js-like-article-count">5</span> 
    <a href="{{ path('article_toggle_heart', {slug: slug}) }}" 
    class="fa fa-heart-o like-article  js-like-article"></a> 
    </span>
#### Ajout de l'argument slug à la méthode show

    return $this->render('news/news.html.twig',[
         'comments' => $comments,
         'title' => ucwords(str_replace('-', ' ', $slug)),
         'slug' => $slug,]
     );     
#### Modification de article_show.js    

    $(document).ready(function() {
        $('.js-like-article').on('click', function(e) {
            e.preventDefault();
    
            var $link = $(e.currentTarget);
            $link.toggleClass('fa-heart-o').toggleClass('fa-heart');
    
            $.ajax({
                method: 'POST',
                url: $link.attr('href')
            }).done(function(data) {
                $('.js-like-article-count').html(data.hearts);
            })
        });
    });
Et voilà, ça fonctionne !         
### Les services
Un service est simplement un objet PHP qui remplit une fonction, associé à une configuration.
#### Utilisation du service de log
Les logs peuvent déjà être affichés via la commande PHP :

    tail -f var/log/dev.log
    
Symfony a son propre service de log: LoggerInterface.

Ajoutons celui-ci à ArticleController :

    use Psr\Log\LoggerInterface;
et dans la méthode toggleArticleHeart() : 

    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts' => random_int(5, 100)]);
    }     
En utilisant le tail -f var/log/dev.log vu plus haut, à chaque clic sur le coeur nous voyons que l'article est aimé 

Pour voir tous les services activés:

      php bin/console debug:autowiring --all
   
#### Utilisation du service markdown

    composer require knplabs/knp-markdown-bundle
Mettre dans le fichier un texte en heredoc -> https://www.php.net/manual/fr/language.types.string.php

    <<<EOF
    Spicy **jalapeno bacon** ipsum dolor amet veniam.
    lorem proident [beef ribs](https://baconipsum.com/). 
    Dolore reprehenderit labore minim pork belly. 
    
    Elit exercitation eiusmod dolore cow
    turkey shank eu pork belly meatball non cupim.
    EOF;
Ajouter dans ArticleController.php

    // dépendance pour le markdown
    use Michelf\MarkdownInterface;
    ...
    public function show($slug, MarkdownInterface $markdown)
    ...
    EOF;
    $articleContent = $markdown->transform($articleContent); 
Voilà, notre texte est retranscrit en markdown (.md), vous trouverez les règles ici:

https://www.markdownguide.org/basic-syntax/

#### Pour voir la configuration d'un service
Nous pouvons voir la configuration par défaut et les options possibles de Twig en utilisant la commande :

    php bin/console config:dump TwigBundle   
        ou
    php bin/console config:dump twig
Pour voir tous les Bundle avec leurs alias :

    php bin/console config:dump
#### Modifions le service knp_markdown    
Regardons knp_markdown :  

    php bin/console config:dump knp_markdown
Créons ensuite un fichier dans config/packages en yaml :

    config/packages/knp_markdown.yml
avec comme contenu :

    knp_markdown:
        parser:
            service: markdown.parser.light
Pour voir le changement de configuration du markdown :

     php bin/console config:dump knp_markdown           
Pour vérifier son activation : 

    php bin/console debug:autowiring     
pour voir tous les services activés :

    php bin/console debug:container --show-private                       
### Passage en production
Pour passer en production, changer dans le fichier .env 

    APP_ENV=dev
Par 

    APP_ENV=prod
Attention, il faut commenter les dump() dans le contrôleur !
### Installation de maker

    composer require maker --dev  

N'oubliez pas de repasser en mode dev dans .env !    

### passage à la version LTS
LTS: Long-Term Support (ici la 4.4.*)

Remplacez dans composer.json, en bas de fichier:

    "extra": {
        "symfony": {
            "allow-contrib": false,
            "require": "4.3.*"
        }
    }
par :

    "extra": {
        "symfony": {
            "allow-contrib": false,
            "require": "4.4.*"
        }
    }
 puis faîtes un composer update
 
    
               