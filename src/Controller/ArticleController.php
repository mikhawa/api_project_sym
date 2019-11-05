<?php

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