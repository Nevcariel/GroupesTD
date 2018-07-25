<?php

namespace App\Controller\Admin;

use App\Entity\Bac;
use App\Form\Bac1Type;
use App\Repository\BacRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/bac")
 */
class BacController extends Controller
{
    /**
     * @Route("/", name="admin_bac_index", methods="GET")
     */
    public function index(BacRepository $bacRepository): Response
    {
        return $this->render('admin/bac/index.html.twig', ['bacs' => $bacRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_bac_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $bac = new Bac();
        $form = $this->createForm(Bac1Type::class, $bac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bac);
            $em->flush();

            return $this->redirectToRoute('admin_bac_index');
        }

        return $this->render('admin/bac/new.html.twig', [
            'bac' => $bac,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_bac_show", methods="GET")
     */
    public function show(Bac $bac): Response
    {
        return $this->render('admin/bac/show.html.twig', ['bac' => $bac]);
    }

    /**
     * @Route("/{id}/edit", name="admin_bac_edit", methods="GET|POST")
     */
    public function edit(Request $request, Bac $bac): Response
    {
        $form = $this->createForm(Bac1Type::class, $bac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bac_edit', ['id' => $bac->getId()]);
        }

        return $this->render('admin/bac/edit.html.twig', [
            'bac' => $bac,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_bac_delete", methods="DELETE")
     */
    public function delete(Request $request, Bac $bac): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bac->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bac);
            $em->flush();
        }

        return $this->redirectToRoute('admin_bac_index');
    }
}
