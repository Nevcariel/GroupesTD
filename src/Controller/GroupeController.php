<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Form\GroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends Controller
{
    /**
     * @Route("/etudiant/liste/groupes", name="etudiant_liste_groupes")
     */
    public function listeGroupes()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiant = $this->getUser();
        $promo = $entityManager->getRepository(Promotion::class)->find($etudiant->getPromotion());
        $groupes = $entityManager->getRepository(Groupe::class)->findBy(['promotion' => $promo]);
        
        return $this->render('etudiant/groupe/liste.html.twig', array(
            'groupes' => $groupes,
            'user' => $etudiant,
        ));
    }

    /**
     * @Route("/etudiant/add/groupe", name="etudiant_add_groupe")
     */
    public function addGroup(Request $request)
    {
        $groupe = new Groupe();
        $groupForm = $this->createForm(GroupeType::class, $groupe);

        $entityManager = $this->getDoctrine()->getManager();
        $etudiant = $this->getUser();
        $promotion = $entityManager->getRepository(Promotion::class)->find($etudiant->getPromotion());

        $groupForm->handleRequest($request);

        if($groupForm->isSubmitted() && $groupForm->isValid())
        {
            $groupe->setTaille(4);
            $promotion->addGroupe($groupe);
            $groupe->addEtudiant($etudiant);
            $groupe->setCreateur($etudiant);
            
            $entityManager->persist($groupe);
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('etudiant/groupe/add.html.twig', array(
            'groupForm' => $groupForm->createView(),
        ));
    }

    /**
     * @Route("/etudiant/join/groupe/{groupe}", name="etudiant_join_groupe")
     */
    public function joinGroupe($groupe)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiant = $this->getUser();
        $groupe = $entityManager->getRepository(Groupe::class)->find($groupe);
        $groupe->addEtudiant($etudiant);
        $entityManager->persist($groupe);
        $entityManager->flush();
        
        return $this->redirectToRoute('etudiant_liste_groupes');
    }

    /**
     * @Route("/etudiant/leave/groupe/{groupe}", name="etudiant_leave_groupe")
     */
    public function leaveGroupe($groupe)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiant = $this->getUser();
        $groupe = $entityManager->getRepository(Groupe::class)->find($groupe);
        $groupe->removeEtudiant($etudiant);
        $entityManager->persist($groupe);
        $entityManager->flush();
        
        return $this->redirectToRoute('etudiant_liste_groupes');
    }

    /**
     * @Route("/etudiant/kick/groupe/{groupe}/{etudiant}", name="etudiant_kick_groupe")
     */
    public function kickGroupe($groupe, $etudiant)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $leVilain = $entityManager->getRepository(Etudiant::class)->find($etudiant);
        $groupe = $entityManager->getRepository(Groupe::class)->find($groupe);
        $groupe->removeEtudiant($leVilain);
        $entityManager->persist($groupe);
        $entityManager->flush();
        
        return $this->redirectToRoute('etudiant_liste_groupes');
    }

    /**
     * @Route("/etudiant/disband/groupe/{groupe}", name="etudiant_disband_groupe")
     */
    public function disbandGroupe($groupe)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $groupe = $entityManager->getRepository(Groupe::class)->find($groupe);
        $etudiants = $groupe->getEtudiants();
        foreach($etudiants as $etudiant)
        {
            $groupe->removeEtudiant($etudiant);
        }
        $entityManager->remove($groupe);
        $entityManager->flush();
        
        return $this->redirectToRoute('etudiant_liste_groupes');
    }
}
