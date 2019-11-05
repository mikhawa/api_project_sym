<?php

// nom de l'espace de travail
namespace App\Controller;

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

    /**
     * @Route("/news/belle-page")
     */
    public function voir()
    {
        return new Response('Voici l\'URL d\'un article!');
    }

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
}