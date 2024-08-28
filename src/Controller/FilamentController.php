<?php

namespace App\Controller;

use App\Entity\Filament;
use App\Form\FilamentType;
use App\Repository\FilamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/filament')]
class FilamentController extends AbstractController
{
    #[Route('/', name: 'app_filament_index', methods: ['GET'])]
    public function index(FilamentRepository $filamentRepository): Response
    {
        return $this->render('filament/index.html.twig', [
            'filaments' => $filamentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filament_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filament = new Filament();
        $form = $this->createForm(FilamentType::class, $filament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filament);
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament/new.html.twig', [
            'filament' => $filament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_show', methods: ['GET'])]
    public function show(Filament $filament): Response
    {
        return $this->render('filament/show.html.twig', [
            'filament' => $filament,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filament_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Filament $filament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilamentType::class, $filament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament/edit.html.twig', [
            'filament' => $filament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_delete', methods: ['POST'])]
    public function delete(Request $request, Filament $filament, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filament->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($filament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filament_index', [], Response::HTTP_SEE_OTHER);
    }
}
