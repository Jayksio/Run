<?php

namespace App\Controller;

use App\Entity\Chaussures;
use App\Form\ChaussuresType;
use App\Repository\ChaussuresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chaussures")
 */
class ChaussuresController extends AbstractController
{
    /**
     * @Route("/", name="app_chaussures_index", methods={"GET"})
     */
    public function index(ChaussuresRepository $chaussuresRepository): Response
    {
        return $this->render('chaussures/index.html.twig', [
            'chaussures' => $chaussuresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout-chaussure", name="app_chaussures_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ChaussuresRepository $chaussuresRepository): Response
    {
        $chaussure = new Chaussures();
        $form = $this->createForm(ChaussuresType::class, $chaussure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chaussuresRepository->add($chaussure, true);

            return $this->redirectToRoute('app_chaussures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chaussures/new.html.twig', [
            'chaussure' => $chaussure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_chaussures_show", methods={"GET"})
     */
    public function show(Chaussures $chaussure): Response
    {
        return $this->render('chaussures/show.html.twig', [
            'chaussure' => $chaussure,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="app_chaussures_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Chaussures $chaussure, ChaussuresRepository $chaussuresRepository): Response
    {
        $form = $this->createForm(ChaussuresType::class, $chaussure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chaussuresRepository->add($chaussure, true);

            return $this->redirectToRoute('app_chaussures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chaussures/edit.html.twig', [
            'chaussure' => $chaussure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_chaussures_delete", methods={"POST"})
     */
    public function delete(Request $request, Chaussures $chaussure, ChaussuresRepository $chaussuresRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $chaussure->getId(), $request->request->get('_token'))) {
            $chaussuresRepository->remove($chaussure, true);
        }

        return $this->redirectToRoute('app_chaussures_index', [], Response::HTTP_SEE_OTHER);
    }
}
