<?php

namespace App\Controller\Admin;

use App\Entity\Dimensions;
use App\Form\DimensionsType;
use App\Repository\CategorieRepository;
use App\Repository\DimensionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dimensions')]
class DimensionsController extends AbstractController
{
    #[Route('/', name: 'app_admin_dimensions_index', methods: ['GET'])]
    public function index(DimensionsRepository $dimensionsRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('admin/dimensions/index.html.twig', [
            'dimensions' => $dimensionsRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
            'nameEntite' => 'dimensions',
        ]);
    }

    #[Route('/new', name: 'app_admin_dimensions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dimension = new Dimensions();
        $form = $this->createForm(DimensionsType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dimension);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_dimensions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dimensions/new.html.twig', [
            'dimension' => $dimension,
            'form' => $form,
            'entite'    => $dimension,
            'nameEntite' => 'dimensions',

        ]);
    }

    #[Route('/{id}', name: 'app_admin_dimensions_show', methods: ['GET'])]
    public function show(Dimensions $dimension): Response
    {
        return $this->render('admin/dimensions/show.html.twig', [
            'dimension' => $dimension,
            'entite'    => $dimension,
            'nameEntite' => 'dimensions',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_dimensions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dimensions $dimension, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DimensionsType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_dimensions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dimensions/edit.html.twig', [
            'dimension' => $dimension,
            'form' => $form,
            'entite'    => $dimension,
            'nameEntite' => 'dimensions',
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dimensions_delete', methods: ['POST'])]
    public function delete(Request $request, Dimensions $dimension, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dimension->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dimension);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_dimensions_index', [], Response::HTTP_SEE_OTHER);
    }
}
