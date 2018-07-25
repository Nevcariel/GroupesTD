<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Form\Etudiant1Type;
use App\Repository\EtudiantRepository;
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
     * @Route("/", name="admin_etudiant_index", methods="GET")
     */
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('admin/etudiant/index.html.twig', ['etudiants' => $etudiantRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_etudiant_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(Etudiant1Type::class, $etudiant);
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
     * @Route("/{id}", name="admin_etudiant_show", methods="GET")
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
        $form = $this->createForm(Etudiant1Type::class, $etudiant);
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
