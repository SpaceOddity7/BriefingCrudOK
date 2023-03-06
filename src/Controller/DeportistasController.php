<?php

namespace App\Controller;

use App\Entity\Deportistas;
use App\Form\DeportistasType;
use App\Repository\DeportistasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/deportistas')]
class DeportistasController extends AbstractController
{
    #[Route('/', name: 'app_deportistas_index', methods: ['GET'])]
    public function index(DeportistasRepository $deportistasRepository): Response
    {
        return $this->render('deportistas/index.html.twig', [
            'deportistas' => $deportistasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_deportistas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DeportistasRepository $deportistasRepository): Response
    {
        $deportista = new Deportistas();
        $form = $this->createForm(DeportistasType::class, $deportista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deportistasRepository->save($deportista, true);

            return $this->redirectToRoute('app_deportistas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deportistas/new.html.twig', [
            'deportista' => $deportista,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deportistas_show', methods: ['GET'])]
    public function show(Deportistas $deportista): Response
    {
        return $this->render('deportistas/show.html.twig', [
            'deportista' => $deportista,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_deportistas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Deportistas $deportista, DeportistasRepository $deportistasRepository): Response
    {
        $form = $this->createForm(DeportistasType::class, $deportista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deportistasRepository->save($deportista, true);

            return $this->redirectToRoute('app_deportistas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deportistas/edit.html.twig', [
            'deportista' => $deportista,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deportistas_delete', methods: ['POST'])]
    public function delete(Request $request, Deportistas $deportista, DeportistasRepository $deportistasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deportista->getId(), $request->request->get('_token'))) {
            $deportistasRepository->remove($deportista, true);
        }

        return $this->redirectToRoute('app_deportistas_index', [], Response::HTTP_SEE_OTHER);
    }
}
