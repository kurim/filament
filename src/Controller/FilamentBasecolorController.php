<?php

namespace App\Controller;

use App\Entity\FilamentBasecolor;
use App\Form\FilamentBasecolorType;
use App\Repository\FilamentBasecolorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/filament/basecolor')]
final class FilamentBasecolorController extends AbstractController
{
    #[Route(name: 'app_filament_basecolor_index', methods: ['GET'])]
    public function index(FilamentBasecolorRepository $filamentBasecolorRepository): Response
    {
        return $this->render('filament_basecolor/index.html.twig', [
            'filament_basecolors' => $filamentBasecolorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filament_basecolor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filamentBasecolor = new FilamentBasecolor();
        $form = $this->createForm(FilamentBasecolorType::class, $filamentBasecolor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filamentBasecolor);
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_basecolor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament_basecolor/new.html.twig', [
            'filament_basecolor' => $filamentBasecolor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_basecolor_show', methods: ['GET'])]
    public function show(FilamentBasecolor $filamentBasecolor): Response
    {
        return $this->render('filament_basecolor/show.html.twig', [
            'filament_basecolor' => $filamentBasecolor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filament_basecolor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FilamentBasecolor $filamentBasecolor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilamentBasecolorType::class, $filamentBasecolor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_basecolor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament_basecolor/edit.html.twig', [
            'filament_basecolor' => $filamentBasecolor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_basecolor_delete', methods: ['POST'])]
    public function delete(Request $request, FilamentBasecolor $filamentBasecolor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filamentBasecolor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($filamentBasecolor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filament_basecolor_index', [], Response::HTTP_SEE_OTHER);
    }
}
