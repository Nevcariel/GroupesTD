<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
use App\Form\VoeuxType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoeuxController extends Controller
{
    /**
     * @Route("/etudiant/voeux", name="etudiant_choix_voeux")
     */
    public function voeux(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $matieres = $entityManager->getRepository(Matiere::class)->findAll();
        $etudiant = $this->getUser();
        $voeuForm = $this->createForm(VoeuxType::class, $etudiant);

        $voeuForm->handleRequest($request);

        if($voeuForm->isSubmitted() && $voeuForm->isValid())
        {
            $entityManager->persist($etudiant);
            $voeuP = $entityManager->getRepository(Matiere::class)->find($etudiant->getVoeuPrincipal());
            $voeuP->addEtudiantPrincipal($etudiant);
            $entityManager->persist($voeuP);
            $voeuS = $entityManager->getRepository(Matiere::class)->find($etudiant->getVoeuSecondaire());
            $voeuS->addEtudiantSecondaire($etudiant);
            $entityManager->persist($voeuS);
            $entityManager->flush();

            return $this->redirectToRoute('etudiant_choix_voeux');
        }

        return $this->render('etudiant/voeux/choix.html.twig', array(
            'matieres' => $matieres,
            'voeuForm' => $voeuForm->createView(),
        ));
    }

    
}