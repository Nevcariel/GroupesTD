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
use App\Form\EtudiantType;
use App\Form\EnseignantType;
use App\Form\BacType;
use App\Form\CsvType;
use App\Service\FileUploader;
use App\Service\CsvReader;
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
        $promo = $entityManager->getRepository(Promotion::class)->find($promotion);
        $groupes = $entityManager->getRepository(Groupe::class)->findBy(['promotion' => $promotion]);

        return $this->render('admin/liste/groupes.html.twig', array(
            'groupes' => $groupes,
            'promotions' => $promotions,
            'promo' => $promo,
        ));
    }

    /**************************** Matières ***************************/

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

        return $this->render('admin/add/matiere.html.twig', array(
            'promotions' => $promotions,
            'matiereForm' => $matiereForm->createView(),
        ));
    }

    /**
    * @Route("/admin/delete/matiere/{matiere}", name="admin_delete_matiere")
    */
    public function deleteMatiere($matiere, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $record = $entityManager->getRepository(Matiere::class)->find($matiere);

        $entityManager->remove($record);
        $entityManager->flush();

        return $this->redirectToRoute('admin_liste_matieres');
    }

    /********************************* Etudiants **********************************/

    /**
    * @Route("/admin/liste/promotions", name="admin_liste_promotions")
    */
    public function listePromotions(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();

        return $this->render('admin/liste/promotions.html.twig', array(
            'promotions' => $promotions,
        ));
    }

    /**
    * @Route("/admin/liste/etudiants/{promo}", name="admin_liste_etudiants")
    */
    public function listeEtudiants($promo, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $promotion = $entityManager->getRepository(Promotion::class)->find($promo);
        $etudiants = $entityManager->getRepository(Etudiant::class)->findBy(['promotion' => $promo]);

        return $this->render('admin/liste/etudiants.html.twig', array(
            'promotions' => $promotions,
            'etudiants' => $etudiants,
            'promotion' => $promotion,
        ));
    }

    /**
    * @Route("/admin/edit/{etudiant}", name="admin_edit_etudiant")
    */
    public function editEtudiant($etudiant, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $etudiant = $entityManager->getRepository(Etudiant::class)->find($etudiant);
        $etudiantForm = $this->createForm(EtudiantType::class, $etudiant);

        $etudiantForm->handleRequest($request);

        if($etudiantForm->isSubmitted() && $etudiantForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_liste_etudiants', array(
                'promo' => $etudiant->getPromotion()->getId(),
            ));
        }

        return $this->render('admin/edit/etudiant.html.twig', array(
            'promotions' => $promotions,
            'etudiantForm' => $etudiantForm->createView(),
        ));
    }

    /**
    * @Route("/admin/add/etudiant", name="admin_add_etudiant")
    */
    public function addEtudiant(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $etudiant = new Etudiant();
        $etudiantForm = $this->createForm(EtudiantType::class, $etudiant);

        $etudiantForm->handleRequest($request);

        if($etudiantForm->isSubmitted() && $etudiantForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_liste_etudiants', array(
                'promo' => $etudiant->getPromotion()->getId(),
            ));
        }

        return $this->render('admin/add/etudiant.html.twig', array(
            'promotions' => $promotions,
            'etudiantForm' => $etudiantForm->createView(),
        ));
    }

    /**
    * @Route("/admin/delete/etudiant/{etudiant}", name="admin_delete_etudiant")
    */
    public function deleteEtudiant($etudiant, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $record = $entityManager->getRepository(Etudiant::class)->find($etudiant);

        $entityManager->remove($record);
        $entityManager->flush();

        return $this->render('admin/dashboard.html.twig', array(
            'promotions' => $promotions,
        ));
    }
    /********************************* Enseignants **********************************/

    /**
    * @Route("/admin/liste/enseignants", name="admin_liste_enseignants")
    */
    public function listEnseignants(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $enseignants = $entityManager->getRepository(Enseignant::class)->findAll();

        return $this->render('admin/liste/enseignants.html.twig', array(
            'promotions' => $promotions,
            'enseignants' => $enseignants,
        ));
    }

    /**
    * @Route("/admin/edit/{enseignant}", name="admin_edit_enseignant")
    */
    public function editEnseignant($enseignant, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $enseignant = $entityManager->getRepository(Enseignant::class)->find($enseignant);
        $enseignantForm = $this->createForm(EnseignantType::class, $enseignant);

        $enseignantForm->handleRequest($request);

        if($enseignantForm->isSubmitted() && $enseignantForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_liste_enseignants');
        }

        return $this->render('admin/edit/enseignant.html.twig', array(
            'promotions' => $promotions,
            'enseignantForm' => $enseignantForm->createView(),
        ));
    }

    /**
    * @Route("/admin/add/enseignant", name="admin_add_enseignant")
    */
    public function addEnseignant(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $enseignant = new Enseignant();
        $enseignantForm = $this->createForm(EnseignantType::class, $enseignant);

        $enseignantForm->handleRequest($request);

        if($enseignantForm->isSubmitted() && $enseignantForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();

            return $this->redirectToRoute('admin_liste_enseignants');
        }

        return $this->render('admin/add/enseignant.html.twig', array(
            'promotions' => $promotions,
            'enseignantForm' => $enseignantForm->createView(),
        ));
    }

    /**
    * @Route("/admin/delete/enseignant/{enseignant}", name="admin_delete_enseignant")
    */
    public function deleteEnseignant($enseignant, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
    
        $record = $entityManager->getRepository(Enseignant::class)->find($enseignant);

        $entityManager->remove($record);
        $entityManager->flush();

        return $this->redirectToRoute('admin_liste_enseignants');
    }

    /**
    * @Route("/admin/upload", name="admin_upload")
    */
    public function upload(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();

        return $this->render('admin/upload/promo_liste.html.twig', array(
            'promotions' => $promotions,
        ));
    }

    /**
    * @Route("/admin/add/promotion", name="admin_create_promo")
    */
    public function createPromotion(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $promotion = new Promotion();
        $promoForm = $this->createForm(PromotionType::class, $promotion);
        

        $promoForm->handleRequest($request);

        if($promoForm->isSubmitted() && $promoForm->isValid())
        {
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->redirectToRoute('admin_upload_csv', array(
                'promotion' => $promotion->getId(),
            ));
        }

        return $this->render('admin/add/promo.html.twig', array(
            'promotions' => $promotions,
            'promoForm' => $promoForm->createView(),
        ));
    }

    /**
    * @Route("/admin/upload/csv/{promotion}", name="admin_upload_csv")
    */
    public function uploadCsv(Promotion $promotion, Request $request, FileUploader $fileUploader)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();

        $csv = new Csv();
        $csvForm = $this->createForm(CsvType::class, $csv);
        $csvForm->handleRequest($request);
        
        if($csvForm->isSubmitted() && $csvForm->isValid())
        {
            $file = $csv->getFile();
            $fileName = $fileUploader->Upload($file);
            $csv->setFile($fileName);
            $csv->setPromotion($promotion);
            $csv->setName($promotion->getAnneeDebut()."/".$promotion->getAnneeFin());
            $entityManager->persist($csv);

            $entityManager->flush();

            return $this->redirectToRoute('admin_import_csv', array(
                'promotion' => $promotion->getId(),
            ));
        }

        return $this->render('admin/upload/csv.html.twig', array(
            'promotions' => $promotions,
            'csvForm' => $csvForm->CreateView(),
        ));
    }

    /**
    * @Route("/admin/import/csv/{promotion}", name="admin_import_csv")
    */
    public function importCsv(Promotion $promotion, Request $request, CsvReader $csvReader)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();
        $promo = $entityManager->getRepository(Promotion::class)->find($promotion);
        $file = $entityManager->getRepository(Csv::class)->findOneBy(['promotion' => $promotion]);
        $fileName = $file->getFile();

        $csvReader->importEtudiantsFromCsv($fileName, $promo, $entityManager);

        return $this->render('admin/liste/etudiants.html.twig', array(
            'promotions' => $promotions,
            'etudiants' => $promo->getEtudiants(),
        ));
    }
}

