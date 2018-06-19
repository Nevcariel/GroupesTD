<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Entity\Matiere;
use App\Entity\Enseignant;
use App\Entity\Csv;
use App\Form\GroupeType;
use App\Form\MatiereType;
use App\Form\PromotionType;
use App\Form\CsvType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="admin_homepage")
     */
    public function dashboard()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        return $this->render('admin/dashboard.html.twig', array(
            'promotions' => $promotions,
        ));
    }
    /**
     * @Route("/admin/liste/groupe/{promotion}", name="admin_liste_groupe")
     */
    public function listeGroupes($promotion, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $groupes = $entityManager->getRepository(Groupe::class)->findBy(['promotion' => $promotion]);

        return $this->render('admin/liste/groupes.html.twig', array(
            'groupes' => $groupes,
            'promotions' => $promotions,
        ));
    }
    /**
    * @Route("/admin/liste/matieres", name="admin_liste_matieres")
    */
    public function listeMatieres(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $matieres = $entityManager->getRepository(Matiere::class)->findAll();

        return $this->render('admin/liste/matieres.html.twig', array(
            'promotions' => $promotions,
            'matieres' => $matieres,
        ));
    }
    /**
    * @Route("/admin/edit/{matiere}", name="admin_edit_matiere")
    */
    public function editMatiere($matiere, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $matiere = $entityManager->getRepository(Matiere::class)->find($matiere);
        $matiereForm = $this->createForm(MatiereType::class, $matiere);

        $matiereForm->handleRequest($request);

        if($matiereForm->isSubmitted() && $matiereForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();

            return $this->redirectToRoute('admin_liste_matieres');
        }

        return $this->render('admin/edit/matiere.html.twig', array(
            'promotions' => $promotions,
            'matiereForm' => $matiereForm->createView(),
        ));
    }
    /**
    * @Route("/admin/add/matiere", name="admin_add_matiere")
    */
    public function addMatiere(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $matiere = new Matiere();
        $matiereForm = $this->createForm(MatiereType::class, $matiere);

        $matiereForm->handleRequest($request);

        if($matiereForm->isSubmitted() && $matiereForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();

            return $this->redirectToRoute('admin_liste_matieres');
        }

        return $this->render('admin/ajouter/matiere.html.twig', array(
            'promotions' => $promotions,
            'matiereForm' => $matiereForm->createView(),
        ));
    }
    /**
    * @Route("/admin/upload/csv", name="admin_upload_csv")
    */
    public function uploadCsv(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $promotion = new Promotion();
        $promoForm = $this->createForm(PromotionType::class, $promotion);
        $csv = new Csv();
        $csvForm = $this->createForm(CsvType::class, $csv);

        $promoForm->handleRequest($request);

        $csvForm->handleRequest($request);

        if($promoForm->isSubmitted() && $promoForm->isValid())
        {
            if($csvForm->isSubmitted() && $csvForm->isValid())
            {
                $entityManager->persist($promotion);

                $csv->setPromotion($promotion);
                $csv->setCsvName($promotion->getAnneeDebut() . "/" . $promotion->getAnneeFin());
                $csv->setCsvSize(filesize($csv->getCsvFile()));
                $csv->setUpdatedAt(new \DateTime('now'));

                $entityManager->persist($csv);
                $entityManager->flush();

                return $this->redirectToRoute('admin_liste_matieres');
            }
        }

        return $this->render('admin/upload/csv.html.twig', array(
            'promotions' => $promotions,
            'promoForm' => $promoForm->createView(),
            'csvForm' => $csvForm->createView(),
        ));
    }
}

