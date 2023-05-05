<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('home.html.twig', [

            'articles' => $articlesRepository->findBy(array(), array('date_creation' => 'desc'), 4),
            /* équivalent SQL : (SELECT * FROM article ORDER BY created_on DESC LIMIT 0,4) */
        ]);
    }

    /**
     * @Route("/mentions-legales", name="app_mentions")
     */
    public function mentions(): Response
    {
        return $this->render('mentions-legales.html.twig', []);
    }
}
