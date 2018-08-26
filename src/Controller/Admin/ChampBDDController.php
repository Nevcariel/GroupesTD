<?php

namespace App\Controller\Admin;

use App\Entity\ChampBDD;
use App\Form\ChampBDDType;
use App\Repository\ChampBDDRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/champ/bdd")
 */
class ChampBDDController extends Controller
{
    /**
     * @Route("/", name="admin_champ_bdd_index", methods="GET")
     */
    public function index(ChampBDDRepository $champBDDRepository): Response
    {
        return $this->render('admin/champ_bdd/index.html.twig', ['champ_bdds' => $champBDDRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_champ_bdd_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $champBDD = new ChampBDD();
        $form = $this->createForm(ChampBDDType::class, $champBDD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($champBDD);
            $em->flush();

            return $this->redirectToRoute('admin_champ_bdd_index');
        }

        return $this->render('admin/champ_bdd/new.html.twig', [
            'champ_bdd' => $champBDD,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_champ_bdd_show", methods="GET")
     */
    public function show(ChampBDD $champBDD): Response
    {
        return $this->render('admin/champ_bdd/show.html.twig', ['champ_bdd' => $champBDD]);
    }

    /**
     * @Route("/{id}/edit", name="admin_champ_bdd_edit", methods="GET|POST")
     */
    public function edit(Request $request, ChampBDD $champBDD): Response
    {
        $form = $this->createForm(ChampBDDType::class, $champBDD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_champ_bdd_edit', ['id' => $champBDD->getId()]);
        }

        return $this->render('admin/champ_bdd/edit.html.twig', [
            'champ_bdd' => $champBDD,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_champ_bdd_delete", methods="DELETE")
     */
    public function delete(Request $request, ChampBDD $champBDD): Response
    {
        if ($this->isCsrfTokenValid('delete'.$champBDD->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($champBDD);
            $em->flush();
        }

        return $this->redirectToRoute('admin_champ_bdd_index');
    }
}
