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