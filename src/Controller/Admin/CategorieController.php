<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_admin_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form->get("couverture")->getData();
            if ($fichier) {
                $nomFichier= pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $slugger = new AsciiSlugger();
                $nouveauNomFichier = $slugger->slug($nomFichier);
                $nouveauNomFichier .="_".uniqid();
                $nouveauNomFichier .= "." .$fichier->guessExtension();
                $fichier->move($this->getParameter("dossier_img_products"),$nouveauNomFichier);
                $categorie->setCouverture($nouveauNomFichier);
            }
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash("success", "la catégorie a bien été ajoutée");
            return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'nameEntite'=>"categorie",
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('admin/categorie/show.html.twig', [
            'categorie' => $categorie,
            'entite'    => $categorie,
            'nameEntite'=>"categorie",
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichier =$form->get("couverture")->getData();
            if ($fichier) {
                if ($categorie->getCouverture()) {
                    $ancienFichier=$this->getParameter("dossier_img_products")."/".$categorie->getCouverture();
                    if (file_exists($ancienFichier)) {
                        /**
                          si vous essayer de supprimer un fichier qui n'existe pas, la fonction unlink renvoie une erreur
                         */
                        unlink($ancienFichier);
                    }
                }
                // on récupère le nom du fichier
                $nomFichier= pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                // pour remplacer les caractères interdits dans les URL, on utilise la classe Asciislugger
                $slugger = new AsciiSlugger();
                $nouveauNomFichier = $slugger->slug($nomFichier);
                // on ajoute un string pour eviter d'avoir des doublons
                $nouveauNomFichier .="_".uniqid();
                // on ajoute l'extension du fichier téléversé
                $nouveauNomFichier .= "." .$fichier->guessExtension();
                // on copie le fichier dans un dossier accessible aux navigateurs clients
                $fichier->move($this->getParameter("dossier_images"),$nouveauNomFichier);
                // on modifie la propriété couverture de l'objet livre
                $categorie->setCouverture($nouveauNomFichier);

            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'entite'    => $categorie,
            'nameEntite'=>"categorie",
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
