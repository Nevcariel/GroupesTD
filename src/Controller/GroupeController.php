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
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promo = $entityManager->getRepository(Promotion::class)->findOneBy(['anneeDebut' => 2017]);
        $groupes = $entityManager->getRepository(Groupe::class)->findBy(['promotion' => $promo]);
        $etudiants = $entityManager->getRepository(Etudiant::class)->findAll();
        return $this->render('index.html.twig', array(
            'groupes' => $groupes,
            'etudiants' => $etudiants,
        ));
    }

    /**
     * @Route("/add", name="add_groupe")
     */
    public function addGroup(Request $request)
    {
        $groupe = new Groupe();
        $groupForm = $this->createForm(GroupeType::class, $groupe);

        $groupForm->handleRequest($request);

        if($groupForm->isSubmitted() && $groupForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('groupe/create.html.twig', array(
            'groupForm' => $groupForm->createView(),
        ));
    }
}
