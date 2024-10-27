<?php

namespace App\Controller;

use App\Entity\FilamentVendor;
use App\Form\FilamentVendorType;
use App\Repository\FilamentVendorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin//filament/vendor')]
final class FilamentVendorController extends AbstractController
{
    #[Route(name: 'app_filament_vendor_index', methods: ['GET'])]
    public function index(FilamentVendorRepository $filamentVendorRepository): Response
    {
        return $this->render('filament_vendor/index.html.twig', [
            'filament_vendors' => $filamentVendorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filament_vendor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filamentVendor = new FilamentVendor();
        $form = $this->createForm(FilamentVendorType::class, $filamentVendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filamentVendor);
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament_vendor/new.html.twig', [
            'filament_vendor' => $filamentVendor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_vendor_show', methods: ['GET'])]
    public function show(FilamentVendor $filamentVendor): Response
    {
        return $this->render('filament_vendor/show.html.twig', [
            'filament_vendor' => $filamentVendor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filament_vendor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FilamentVendor $filamentVendor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilamentVendorType::class, $filamentVendor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filament_vendor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filament_vendor/edit.html.twig', [
            'filament_vendor' => $filamentVendor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filament_vendor_delete', methods: ['POST'])]
    public function delete(Request $request, FilamentVendor $filamentVendor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filamentVendor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($filamentVendor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filament_vendor_index', [], Response::HTTP_SEE_OTHER);
    }
}
