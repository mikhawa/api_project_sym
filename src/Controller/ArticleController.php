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