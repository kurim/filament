<?php

namespace App\Controller;

use App\Entity\FilamentMaterial;
use App\Form\FilamentMaterialType;
use App\Repository\FilamentMaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin//filament/material')]
final class FilamentMaterialController extends AbstractController
{
    #[Route(name: 'app_filament_material_index', methods: ['GET'])]
    public function index(FilamentMaterialRepository $filamentMaterialRepository): Response
    {
        return $this->render('filament_material/index.html.twig', [
            'filament_materials' => $filamentMaterialRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filament_material_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filamentMaterial = new FilamentMaterial();
        $form = $this->createForm(FilamentMaterialType::class, $filamentMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filamentMaterial);
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament_material/new.html.twig', [
            'filament_material' => $filamentMaterial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_material_show', methods: ['GET'])]
    public function show(FilamentMaterial $filamentMaterial): Response
    {
        return $this->render('filament_material/show.html.twig', [
            'filament_material' => $filamentMaterial,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filament_material_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FilamentMaterial $filamentMaterial, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilamentMaterialType::class, $filamentMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament_material/edit.html.twig', [
            'filament_material' => $filamentMaterial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_material_delete', methods: ['POST'])]
    public function delete(Request $request, FilamentMaterial $filamentMaterial, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filamentMaterial->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($filamentMaterial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filament_material_index', [], Response::HTTP_SEE_OTHER);
    }
}
