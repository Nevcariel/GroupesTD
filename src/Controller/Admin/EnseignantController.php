<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use App\Form\Enseignant1Type;
use App\Repository\EnseignantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/enseignant")
 */
class EnseignantController extends Controller
{
    /**
     * @Route("/", name="admin_enseignant_index", methods="GET")
     */
    public function index(EnseignantRepository $enseignantRepository): Response
    {
        return $this->render('admin/enseignant/index.html.twig', ['enseignants' => $enseignantRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_enseignant_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(Enseignant1Type::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignant);
            $em->flush();

            return $this->redirectToRoute('admin_enseignant_index');
        }

        return $this->render('admin/enseignant/new.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_enseignant_show", methods="GET")
     */
    public function show(Enseignant $enseignant): Response
    {
        return $this->render('admin/enseignant/show.html.twig', ['enseignant' => $enseignant]);
    }

    /**
     * @Route("/{id}/edit", name="admin_enseignant_edit", methods="GET|POST")
     */
    public function edit(Request $request, Enseignant $enseignant): Response
    {
        $form = $this->createForm(Enseignant1Type::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_enseignant_edit', ['id' => $enseignant->getId()]);
        }

        return $this->render('admin/enseignant/edit.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_enseignant_delete", methods="DELETE")
     */
    public function delete(Request $request, Enseignant $enseignant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enseignant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enseignant);
            $em->flush();
        }

        return $this->redirectToRoute('admin_enseignant_index');
    }
}
