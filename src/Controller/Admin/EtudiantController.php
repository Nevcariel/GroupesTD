<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Form\Admin\EtudiantType;
use App\Form\Admin\PromotionChoiceType;
use App\Repository\EtudiantRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/etudiant")
 */
class EtudiantController extends Controller
{
    /**
     * @Route("/", name="admin_etudiant_index", methods="GET|POST")
     */
    public function index(EtudiantRepository $etudiantRepository, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = new Etudiant();
        $form = $this->createForm(PromotionChoiceType::class, $promotions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            return $this->redirectToRoute('admin_etudiant_index_filtered', [
                'id' => $form['promotion']->getData()->getId(),
            ]);
        }

        return $this->render('admin/etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/list", name="admin_etudiant_index_filtered", methods="GET|POST")
     */
    public function filteredIndex(Request $request, Promotion $promotion): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = new Etudiant();
        $form = $this->createForm(PromotionChoiceType::class, $promotions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            return $this->redirectToRoute('admin_etudiant_index_filtered', [
                'id' => $form->get('promotion')->getData()->getId(),
            ]);
        }

        return $this->render('admin/etudiant/index.html.twig', [
            'etudiants' => $promotion->getEtudiants(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="admin_etudiant_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('admin_etudiant_index');
        }

        return $this->render('admin/etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_etudiant_show", methods="GET")
     */
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('admin/etudiant/show.html.twig', ['etudiant' => $etudiant]);
    }

    /**
     * @Route("/{id}/edit", name="admin_etudiant_edit", methods="GET|POST")
     */
    public function edit(Request $request, Etudiant $etudiant): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_etudiant_edit', ['id' => $etudiant->getId()]);
        }

        return $this->render('admin/etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_etudiant_delete", methods="DELETE")
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();
        }

        return $this->redirectToRoute('admin_etudiant_index');
    }
}
