<?php

namespace App\Controller\Admin;

use App\Entity\Matiere;
use App\Form\Matiere1Type;
use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/matiere")
 */
class MatiereController extends Controller
{
    /**
     * @Route("/", name="admin_matiere_index", methods="GET")
     */
    public function index(MatiereRepository $matiereRepository): Response
    {
        return $this->render('admin/matiere/index.html.twig', ['matieres' => $matiereRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_matiere_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(Matiere1Type::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($matiere);
            $em->flush();

            return $this->redirectToRoute('admin_matiere_index');
        }

        return $this->render('admin/matiere/new.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_matiere_show", methods="GET")
     */
    public function show(Matiere $matiere): Response
    {
        return $this->render('admin/matiere/show.html.twig', ['matiere' => $matiere]);
    }

    /**
     * @Route("/{id}/edit", name="admin_matiere_edit", methods="GET|POST")
     */
    public function edit(Request $request, Matiere $matiere): Response
    {
        $form = $this->createForm(Matiere1Type::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_matiere_edit', ['id' => $matiere->getId()]);
        }

        return $this->render('admin/matiere/edit.html.twig', [
            'matiere' => $matiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_matiere_delete", methods="DELETE")
     */
    public function delete(Request $request, Matiere $matiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matiere->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($matiere);
            $em->flush();
        }

        return $this->redirectToRoute('admin_matiere_index');
    }
}
