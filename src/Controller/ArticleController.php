<?php

// nom de l'espace de travail
namespace App\Controller;

// dépendance pour utiliser Twig et les autres dépendances liées au contrôleur:
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// dépendance pour utiliser json :
use Symfony\Component\HttpFoundation\JsonResponse;
// dépendance pour les annotations
use Symfony\Component\Routing\Annotation\Route;
// dépendance pour les logs
use Psr\Log\LoggerInterface;
// dépendance pour le markdown
use Michelf\MarkdownInterface;

// class
class ArticleController extends AbstractController
{
    // méthode d'accueil avec annotations
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('news/homepage.html.twig');
    }


    /**
     * @Route("/news/{slug}", name="articles")
     */
    public function show($slug, MarkdownInterface $markdown)
    {
        dump($slug, $this);
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        // contenu heredoc
        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
turkey shank eu pork belly meatball non cupim.

Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.

Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;
        $articleContent = $markdown->transform($articleContent);
        return $this->render('news/news.html.twig',[
                'articleContent' => $articleContent,
                'comments' => $comments,
                'title' => ucwords(str_replace('-', ' ', $slug)),
                'slug' => $slug,]
        );
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts' => random_int(5, 100)]);
    }
}