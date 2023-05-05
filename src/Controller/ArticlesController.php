<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="app_articles_index", methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }


    /**
     * @Route("/alimentation", name="app_articles_alimentation", methods={"GET"})
     */
    public function alimentation(ArticlesRepository $articlesRepository): Response
    {
        $article = $articlesRepository->findBy(["categories" => "0"], array('date_creation' => 'desc'));
        return $this->render('articles/alimentation.html.twig', [
            /* 'articles' => $articlesRepository->findAll(), */
            'articles' => $article,
            /* équivalent SQL : (SELECT * FROM articles WHERE categories = "0" ORDER BY date_creation DESC) */
        ]);
    }

    /**
     * @Route("/entrainement", name="app_articles_entrainement", methods={"GET"})
     */
    public function entrainement(ArticlesRepository $articlesRepository): Response
    {
        $article = $articlesRepository->findBy(["categories" => "1"], array('date_creation' => 'desc'));
        return $this->render('articles/entrainement.html.twig', [
            /* 'articles' => $articlesRepository->findAll(), */
            'articles' => $article,
            /* équivalent SQL : (SELECT * FROM articles WHERE categories = "1" ORDER BY date_creation DESC) */
        ]);
    }

    /**
     * @Route("/sante", name="app_articles_sante", methods={"GET"})
     */
    public function sante(ArticlesRepository $articlesRepository): Response
    {
        $article = $articlesRepository->findBy(["categories" => "2"], array('date_creation' => 'desc'));
        return $this->render('articles/sante.html.twig', [
            /* 'articles' => $articlesRepository->findAll(), */
            'articles' => $article,
            /* équivalent SQL : (SELECT * FROM articles WHERE categories = "2" ORDER BY date_creation DESC) */
        ]);
    }

    /**
     * @Route("/bienetre", name="app_articles_bienetre", methods={"GET"})
     */
    public function bienEtre(ArticlesRepository $articlesRepository): Response
    {
        $article = $articlesRepository->findBy(["categories" => "3"], array('date_creation' => 'desc'));
        return $this->render('articles/bien-etre.html.twig', [
            /* 'articles' => $articlesRepository->findAll(), */
            'articles' => $article,
            /* équivalent SQL : (SELECT * FROM articles WHERE categories = "3" ORDER BY date_creation DESC) */


        ]);
    }


    /**
     * @Route("/ajout-article", name="app_articles_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArticlesRepository $articlesRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDateCreation(new \DateTime('now'));
            $articlesRepository->add($article, true);


            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_article_show", methods={"GET", "POST"})
     */
    public function show(Articles $article, EntityManagerInterface $doctrine, Request $requete, CommentairesRepository $comR, ArticlesRepository $articlesRepository): Response
    {
        if (!$article) {
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }


        // instance de "Commentaires"
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($requete);
        // $username = $this->getUser();
        // Nous vérifions si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setDatePublication(new \DateTime());
            $commentaire->setArticles($article);
            $doctrine->persist($commentaire);
            $doctrine->flush();
        }
        $categories = $article->getCategories();
        $suggestion = $articlesRepository->findBy(['categories' => $categories], ['date_creation' => 'asc'], 3);


        // Si l'article existe nous envoyons les données à la vue
        return $this->render('articles/show.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'commentaires' => $comR->findBy(['articles' => $article], ['date_publication' => 'desc']),
            'suggestions' => $suggestion,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="app_articles_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->add($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_articles_delete", methods={"POST"})
     */
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
