<?php

namespace App\Controller\Admin;

use App\Entity\Groupe;
use App\Form\Admin\GroupeType;
use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/groupe")
 */
class GroupeController extends Controller
{
    /**
     * @Route("/", name="admin_groupe_index", methods="GET")
     */
    public function index(GroupeRepository $groupeRepository): Response
    {
        return $this->render('admin/groupe/index.html.twig', ['groupes' => $groupeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_groupe_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('admin_groupe_index');
        }

        return $this->render('admin/groupe/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_groupe_show", methods="GET")
     */
    public function show(Groupe $groupe): Response
    {
        return $this->render('admin/groupe/show.html.twig', ['groupe' => $groupe]);
    }

    /**
     * @Route("/{id}/edit", name="admin_groupe_edit", methods="GET|POST")
     */
    public function edit(Request $request, Groupe $groupe): Response
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_groupe_edit', ['id' => $groupe->getId()]);
        }

        return $this->render('admin/groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_groupe_delete", methods="DELETE")
     */
    public function delete(Request $request, Groupe $groupe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($groupe);
            $em->flush();
        }

        return $this->redirectToRoute('admin_groupe_index');
    }
}
